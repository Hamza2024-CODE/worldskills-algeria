<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\DelegationMember;
use App\Models\Registration;
use App\Models\RoomAllocation;
use App\Models\User;
use App\Models\Zone;
use App\Services\Rules\WsapAccessRulesEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminQrScanner extends Component
{
    public string            $query              = '';
    public ?User             $scannedUser        = null;
    public ?Badge            $scannedBadge       = null;
    public ?DelegationMember $delegationMember   = null;
    public ?Registration     $registration       = null;
    public ?RoomAllocation   $roomAllocation     = null;
    public array             $zonePermissions    = [];
    public array             $allZones           = [];
    public array             $accessDecision     = [];
    public bool              $showOverrideModal  = false;
    public string            $overrideReasonAr   = '';

    public function mount(): void
    {
        $this->allZones = Zone::where('is_active', true)->get()->toArray();
    }

    public function scan(WsapAccessRulesEngine $rulesEngine): void
    {
        $this->scannedUser      = null;
        $this->scannedBadge     = null;
        $this->delegationMember = null;
        $this->registration     = null;
        $this->roomAllocation   = null;
        $this->zonePermissions  = [];
        $this->accessDecision   = [];

        $clean = trim($this->query);

        if (empty($clean)) {
            return;
        }

        // Evaluate access rules via central engine
        $this->accessDecision = $rulesEngine->evaluateAccess($clean);
        $this->scannedBadge    = $this->accessDecision['badge'] ?? null;
        $this->scannedUser     = $this->accessDecision['user'] ?? null;

        if (!$this->scannedUser) {
            // Smart fallback user lookup
            $this->scannedUser = User::with([
                'roles',
                'country',
                'wilaya',
                'organization',
                'participant.registrations.skill',
                'participant.registrations.country',
            ])
            ->where('email', $clean)
            ->orWhere('uuid', $clean)
            ->orWhere('id', $clean)
            ->orWhereHas('participant.registrations', function($q) use ($clean) {
                $q->where('registration_number', $clean);
            })
            ->first();
        } else {
            $this->scannedUser->loadMissing([
                'roles',
                'country',
                'wilaya',
                'organization',
                'participant.registrations.skill',
                'participant.registrations.country',
            ]);
        }

        if (!$this->scannedUser && str_contains($clean, '_')) {
            $parts = explode('_', $clean);
            $possibleEmail = end($parts);
            if (filter_var($possibleEmail, FILTER_VALIDATE_EMAIL)) {
                $this->scannedUser = User::with([
                    'roles',
                    'country',
                    'wilaya',
                    'organization',
                    'participant.registrations.skill',
                    'participant.registrations.country',
                ])->where('email', $possibleEmail)->first();
            }
        }

        if ($this->scannedUser) {
            // Load delegation member profile
            $this->delegationMember = DelegationMember::with(['skill', 'delegation.country'])
                ->where('user_id', $this->scannedUser->id)
                ->orWhere('email', $this->scannedUser->email)
                ->first();

            // Load latest registration
            if ($this->scannedUser->participant) {
                $this->registration = Registration::with(['skill', 'country'])
                    ->where('participant_id', $this->scannedUser->participant->id)
                    ->latest()
                    ->first();
            }

            // Load room allocation & accommodation
            $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                ->where('user_id', $this->scannedUser->id)
                ->first();

            if (!$this->roomAllocation && $this->scannedUser->participant) {
                $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                    ->where('participant_profile_id', $this->scannedUser->participant->id)
                    ->first();
            }
        }

        if (!$this->scannedBadge && $this->scannedUser) {
            $this->scannedBadge = Badge::where('user_id', $this->scannedUser->id)->first();
        }

        if ($this->scannedBadge) {
            $this->zonePermissions = BadgeZonePermission::with('zone')
                ->where('badge_id', $this->scannedBadge->id)
                ->get()
                ->toArray();
        }

        // Build composite zone permissions list against all active zones
        $zones = !empty($this->allZones) ? $this->allZones : Zone::all()->toArray();
        $allowedIds = $this->scannedBadge?->allowed_zone_ids ?? [1, 2, 3, 4, 5];

        $permissionMap = [];
        foreach ($this->zonePermissions as $zp) {
            if (isset($zp['zone_id'])) {
                $permissionMap[$zp['zone_id']] = $zp['permission'] ?? 'ALLOW';
            }
        }

        $compositePermissions = [];
        foreach ($zones as $z) {
            $zId = $z['id'];
            $isExplicitAllowed = isset($permissionMap[$zId]) && $permissionMap[$zId] === 'ALLOW';
            $isInAllowedArray = in_array($zId, $allowedIds);
            
            $permission = ($isExplicitAllowed || $isInAllowedArray) ? 'ALLOW' : 'DENY';
            $compositePermissions[] = [
                'zone_id'    => $zId,
                'permission' => $permission,
                'zone'       => $z,
            ];
        }

        $this->zonePermissions = $compositePermissions;
    }

    public function executeOverride(WsapAccessRulesEngine $rulesEngine): void
    {
        $this->validate([
            'overrideReasonAr' => 'required|string|min:3',
        ]);

        if ($this->query) {
            $this->accessDecision = $rulesEngine->evaluateAccessWithOverride($this->query, $this->overrideReasonAr);
            $this->showOverrideModal = false;
            $this->overrideReasonAr = '';
        }
    }

    public function render()
    {
        return view('livewire.admin.qr-scanner');
    }
}
