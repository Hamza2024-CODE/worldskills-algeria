<?php

namespace App\Services\Rules;

use App\Models\AccessDecisionLog;
use App\Models\AuditLog;
use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\MealEntitlement;
use App\Models\MealSlot;
use App\Models\ScheduleEvent;
use App\Models\User;
use App\Models\Zone;
use App\Services\Emergency\EmergencyControlService;
use Illuminate\Support\Facades\DB;

class WsapAccessRulesEngine
{
    protected EmergencyControlService $emergencyService;
    protected AntiPassbackEngine $antiPassbackEngine;

    public function __construct(?EmergencyControlService $emergencyService = null, ?AntiPassbackEngine $antiPassbackEngine = null)
    {
        $this->emergencyService   = $emergencyService ?: app(EmergencyControlService::class);
        $this->antiPassbackEngine = $antiPassbackEngine ?: app(AntiPassbackEngine::class);
    }

    /**
     * Universal access evaluation pipeline in WSAP V8.4.
     */
    public function evaluateAccess(
        string|int $badgeIdentifier,
        ?string $serviceType = null,
        ?string $serviceId = null,
        ?int $zoneId = null,
        ?string $scannerUserId = null
    ): array {
        $rawBadge   = trim((string) $badgeIdentifier);
        $cleanBadge = $this->extractCleanIdentifier($rawBadge);

        if (empty($cleanBadge)) {
            return $this->deny('BADGE_NOT_FOUND', 'الشارة غير معروفة في النظام', 'Unknown badge identifier', null, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 1. Emergency Lockdown Check
        if ($serviceType && $this->emergencyService->isScopeLockedDown($serviceType, $serviceId)) {
            return $this->deny('EMERGENCY_LOCKDOWN_ACTIVE', 'الموقع أو الخدمة تحت وضع الإغلاق الأمني التام للطوارئ', 'Service under active emergency lockdown', null, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 2. Resolve Badge (or User)
        $badge = $this->resolveBadge($cleanBadge, $rawBadge);

        if (!$badge) {
            return $this->deny('BADGE_NOT_FOUND', 'الشارة غير معروفة في النظام', 'Unknown badge identifier', null, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 3. Revocation / Loss Check
        if ($badge->status === 'LOST') {
            return $this->deny('BADGE_LOST', 'تم الإبلاغ عن فقدان هذه الشارة ومحظور استخدامها', 'Badge reported lost', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        if (in_array($badge->status, ['REVOKED', 'SUSPENDED', 'INACTIVE', 'BLOCKED'])) {
            return $this->deny('BADGE_REVOKED', 'الشارة ملغاة أو معلقة من قِبل إدارة الأمن', 'Badge is revoked or suspended', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        $user = $badge->user;
        if (!$user || !$user->is_active) {
            return $this->deny('USER_INACTIVE', 'حساب المستخدم المعني غير نشط', 'User account is inactive', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 4. Anti-Passback Check
        if ($serviceType && $this->antiPassbackEngine->isPassbackViolation($badge, $serviceType, $serviceId, 5)) {
            return $this->deny('ANTI_PASSBACK_VIOLATION', 'تنبيه منع التمرير المزدوج: تم مسح الشارة في هذا الموقع منذ أقل من 5 دقائق', 'Anti-passback rule violated', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 5. Zone Permission check (if zoneId provided)
        if ($zoneId) {
            $zone = Zone::find($zoneId);
            if ($zone && !$zone->is_active) {
                return $this->deny('ZONE_INACTIVE', 'منطقة الوصول المغلقة مؤقتاً', 'Zone is temporarily inactive', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }

            $zonePerm = BadgeZonePermission::where('badge_id', $badge->id)
                ->where('zone_id', $zoneId)
                ->first();

            if ($zonePerm && !$zonePerm->isValidAt(now())) {
                return $this->deny('ZONE_DENIED', 'الوصول لهذه المنطقة غير مسموح بهذه الشارة', 'Access to this zone is unauthorized for this badge', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }
        }

        // 6. Meal Slot Entitlement & Transaction-Safe Capacity check
        if ($serviceType === 'MEAL_SLOT' && $serviceId) {
            return $this->evaluateMealSlotAccess($badge, $user, (int) $serviceId, $zoneId, $scannerUserId);
        }

        // 7. Schedule Event Access check
        if ($serviceType === 'SCHEDULE_EVENT' && $serviceId) {
            $event = ScheduleEvent::find($serviceId);
            if (!$event || in_array($event->status, ['CANCELLED', 'ARCHIVED'])) {
                return $this->deny('EVENT_CANCELLED', 'الحدث غير متاح أو تم إلغاؤه', 'Event is unavailable or cancelled', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }
        }

        return $this->allow('ACCESS_GRANTED', 'تم منح إذن الوصول والموافقة 100%', 'Access authorized', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
    }

    /**
     * Super Admin Emergency Override execution with mandatory audit reason.
     */
    public function evaluateAccessWithOverride(
        string|int $badgeIdentifier,
        string $overrideReasonAr,
        ?string $serviceType = null,
        ?string $serviceId = null,
        ?int $zoneId = null
    ): array {
        $cleanBadge = trim((string) $badgeIdentifier);
        $badge = Badge::where('access_token', $cleanBadge)
            ->orWhere('badge_uuid', $cleanBadge)
            ->orWhere('id', $cleanBadge)
            ->first();

        AuditLog::create([
            'event'       => 'SUPER_ADMIN_EMERGENCY_OVERRIDE',
            'user_id'     => auth()->id() ?: 1,
            'target_type' => Badge::class,
            'target_id'   => $badge?->id ?? 0,
            'meta'        => [
                'reason'       => $overrideReasonAr,
                'badge_uuid'   => $badge?->badge_uuid,
                'service_type' => $serviceType,
                'service_id'   => $serviceId,
            ],
        ]);

        return $this->allow('SUPER_ADMIN_OVERRIDE', "تجاوز طارئ مصرح به من مدير النظام: {$overrideReasonAr}", "Emergency Super Admin Override: {$overrideReasonAr}", $badge, $zoneId, $serviceType, $serviceId, auth()->id());
    }

    /**
     * Transaction-safe meal slot entitlement and capacity evaluation with pessimistic locking.
     */
    protected function evaluateMealSlotAccess(Badge $badge, User $user, int $slotId, ?int $zoneId, ?string $scannerUserId): array
    {
        return DB::transaction(function () use ($badge, $user, $slotId, $zoneId, $scannerUserId) {
            $slot = MealSlot::where('id', $slotId)->lockForUpdate()->first();

            if (!$slot || !$slot->is_open) {
                return $this->deny('MEAL_SLOT_CLOSED', 'فترة الوجبة مغلقة أو غير متاحة', 'Meal slot is closed', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            if (!empty($slot->date) && !\Carbon\Carbon::parse($slot->date)->isToday()) {
                return $this->deny('MEAL_SLOT_OUTSIDE_DATE', 'موعد الوجبة خارج الإطار الزمني المسموح', 'Meal slot is outside valid time window', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            $currentCount = $slot->scans()->count();
            if ($slot->max_capacity > 0 && $currentCount >= $slot->max_capacity) {
                return $this->deny('MEAL_CAPACITY_EXCEEDED', 'تم الوصول للحد الأقصى لاستيعاب هذا المطعم', 'Meal slot capacity exceeded', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            $countryId = $user->country_id ?: $user->participant?->registrations?->first()?->country_id;

            $hasEntitlement = MealEntitlement::where('meal_slot_id', $slotId)
                ->where(function ($q) use ($user, $countryId) {
                    $q->where('user_id', $user->id);
                    if ($countryId) {
                        $q->orWhere('country_id', $countryId);
                    }
                })
                ->exists();

            if (!$hasEntitlement) {
                return $this->deny('MEAL_NOT_ENTITLED', 'هذا المطعم والوجبة غير مخصصين لهذا المستخدم', 'User is not entitled to this meal slot', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            return $this->allow('MEAL_AUTHORIZED', 'الوجبة مخصصة ومصرح بها 100%', 'Meal access authorized', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
        });
    }

    protected function allow(string $code, string $msgAr, string $msgEn, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): array
    {
        $res = [
            'is_allowed'  => true,
            'reason_code' => $code,
            'message_ar'  => $msgAr,
            'message_en'  => $msgEn,
            'badge'       => $badge,
            'user'        => $badge?->user,
        ];
        $this->recordAccessDecision('ALLOW', $code, $msgAr, $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        return $res;
    }

    protected function deny(string $code, string $msgAr, string $msgEn, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): array
    {
        $res = [
            'is_allowed'  => false,
            'reason_code' => $code,
            'message_ar'  => $msgAr,
            'message_en'  => $msgEn,
            'badge'       => $badge,
            'user'        => $badge?->user,
        ];
        $this->recordAccessDecision('DENY', $code, $msgAr, $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        return $res;
    }

    private function recordAccessDecision(string $decision, string $code, string $msgAr, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): void
    {
        AccessDecisionLog::create([
            'badge_id'          => $badge?->id,
            'user_id'           => $badge?->user_id,
            'service_type'      => $serviceType ?: 'GENERAL',
            'service_id'        => $serviceId ? (string) $serviceId : null,
            'zone_id'           => $zoneId,
            'decision'          => $decision,
            'reason_code'       => $code,
            'reason_message_ar' => $msgAr,
            'scanned_by'        => $scannerUserId ?: (auth()->id() ?: 1),
            'scanned_at'        => now(),
        ]);

        AuditLog::create([
            'event'       => 'ACCESS_' . $decision,
            'user_id'     => $badge?->user_id ?? (auth()->id() ?: 1),
            'target_type' => Badge::class,
            'target_id'   => $badge?->id ?? 0,
            'meta'        => [
                'reason_code'  => $code,
                'message_ar'   => $msgAr,
                'badge_uuid'   => $badge?->badge_uuid,
                'service_type' => $serviceType,
                'service_id'   => $serviceId,
                'zone_id'      => $zoneId,
            ],
        ]);
    }

    /**
     * Clean and extract identifier from raw input (URLs, tokens, emails, etc.)
     */
    protected function extractCleanIdentifier(string $raw): string
    {
        $clean = trim($raw);
        if (empty($clean)) {
            return '';
        }

        if (filter_var($clean, FILTER_VALIDATE_URL) || str_contains($clean, 'http://') || str_contains($clean, 'https://')) {
            $parsed = parse_url($clean);
            if (isset($parsed['query'])) {
                parse_str($parsed['query'], $queryParams);
                foreach (['identifier', 'token', 'badge', 'id', 'uuid', 'code', 'user_id', 'email', 'number'] as $key) {
                    if (!empty($queryParams[$key])) {
                        return trim((string) $queryParams[$key]);
                    }
                }
            }
            if (isset($parsed['path'])) {
                $path = rtrim($parsed['path'], '/');
                $segments = array_filter(explode('/', $path));
                if (!empty($segments)) {
                    $lastSegment = end($segments);
                    if (!empty($lastSegment) && !in_array(strtolower($lastSegment), ['dashboard', 'scanner', 'badge', 'accreditation', 'certificate', 'verify', 'official'])) {
                        return trim($lastSegment);
                    }
                }
            }
        }

        return $clean;
    }

    /**
     * Resolve badge model or auto-bind active badge for registered user.
     */
    protected function resolveBadge(string $cleanBadge, string $rawBadge): ?Badge
    {
        // Direct search on Badge
        $badge = Badge::with(['user.roles', 'user.country', 'user.participant.registrations'])
            ->where('access_token', $cleanBadge)
            ->orWhere('badge_uuid', $cleanBadge)
            ->orWhere('id', $cleanBadge)
            ->first();

        if (!$badge && strlen($cleanBadge) >= 6) {
            $badge = Badge::with(['user.roles', 'user.country', 'user.participant.registrations'])
                ->where('badge_uuid', 'like', $cleanBadge . '%')
                ->orWhere('access_token', 'like', $cleanBadge . '%')
                ->first();
        }

        if ($badge) {
            return $badge;
        }

        // Search User
        $user = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])
            ->where('email', $cleanBadge)
            ->orWhere('email', $rawBadge)
            ->orWhere('uuid', $cleanBadge)
            ->orWhere('id', $cleanBadge)
            ->first();

        if (!$user) {
            $member = \App\Models\DelegationMember::where('email', $cleanBadge)
                ->orWhere('email', $rawBadge)
                ->orWhere('passport_number', $cleanBadge)
                ->orWhere('nin_number', $cleanBadge)
                ->first();

            if ($member && $member->user_id) {
                $user = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])->find($member->user_id);
            }
        }

        if (!$user) {
            $registration = \App\Models\Registration::where('registration_number', $cleanBadge)->first();
            if ($registration && $registration->participant?->user_id) {
                $user = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])->find($registration->participant->user_id);
            }
        }

        if (!$user) {
            return null;
        }

        $badge = Badge::where('user_id', $user->id)->first();

        if (!$badge) {
            $roleTitle = $user->roles->first()?->name ?: 'MEMBER';
            $badge = Badge::create([
                'user_id'          => $user->id,
                'badge_uuid'       => $user->uuid ?: (string) \Illuminate\Support\Str::uuid(),
                'access_token'     => \Illuminate\Support\Str::random(32),
                'role_title'       => $roleTitle,
                'status'           => 'ACTIVE',
                'allowed_zone_ids' => [1, 2, 3, 4, 5],
                'valid_until'      => now()->addYear(),
            ]);
        }

        $badge->loadMissing(['user.roles', 'user.country', 'user.participant.registrations']);
        return $badge;
    }
}
