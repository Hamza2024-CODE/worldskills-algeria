<?php

namespace App\Livewire\Public;

use App\Models\Badge;
use App\Models\DelegationMember;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\User;
use App\Services\CertificateService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class AccreditationBadge extends Component
{
    public ?Badge $badge = null;
    public ?Registration $registration = null;
    public ?User $user = null;
    public string $roleTitle = 'COMPETITOR';
    public string $token = '';

    public function mount(string $identifier)
    {
        $service = new CertificateService();

        // 1. Try finding User directly by uuid, id, or email FIRST to guarantee system accounts (e.g. viewer@worldskills.dz, dz.admin@worldskills.dz) resolve correctly
        $user = User::with(['roles', 'country', 'organization', 'wilaya', 'participant'])
            ->where('uuid', $identifier)
            ->orWhere('id', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if ($user) {
            $this->user = $user;
            $userRole  = $user->roles->first()?->name;
            $roleTitle = match ($userRole) {
                'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
                'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
                'MEDIA_MANAGER'                     => 'MEDIA',
                'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                default                             => 'COMPETITOR',
            };

            $this->badge = Badge::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'badge_uuid'   => (string) Str::uuid(),
                    'access_token' => Str::random(32),
                    'role_title'   => $roleTitle,
                    'status'       => 'ACTIVE',
                ]
            );

            $this->badge->update(['role_title' => $roleTitle]);

            $this->roleTitle = strtoupper($this->badge->role_title);
            $this->token     = $this->badge->access_token;
            $this->registration = Registration::with(['participant', 'country', 'skill', 'organization', 'wilaya'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $user->id))
                ->first();
            $this->checkRejectionEligibility();
            return;
        }

        // 2. Try finding badge by access_token or badge_uuid
        $this->badge = Badge::with('user.roles')
            ->where('access_token', $identifier)
            ->orWhere('badge_uuid', $identifier)
            ->first();

        if ($this->badge) {
            $userRole = $this->badge->user?->roles->first()?->name;
            $overrideRole = match ($userRole) {
                'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
                'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
                'MEDIA_MANAGER'                     => 'MEDIA',
                'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                default                             => null,
            };

            $this->roleTitle = $overrideRole ?? strtoupper($this->badge->role_title);
            $this->token     = $this->badge->access_token;
            $this->user      = $this->badge->user;

            $this->registration = Registration::with(['participant', 'country', 'skill', 'organization', 'wilaya'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $this->badge->user_id))
                ->first();
            $this->checkRejectionEligibility();
            return;
        }

        // 3. Try finding DelegationMember by uuid, id, passport_number, nin_number, or email
        $delegationMember = DelegationMember::with(['delegation.country', 'skill', 'user'])
            ->where('uuid', $identifier)
            ->orWhere('id', $identifier)
            ->orWhere('passport_number', $identifier)
            ->orWhere('nin_number', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if ($delegationMember) {
            $roleKey = strtoupper($delegationMember->member_type ?? 'PARTICIPANT');
            $this->roleTitle = match ($roleKey) {
                'MINISTERIAL_OBSERVER', 'MINISTERIAL OBSERVER', 'EXECUTIVE_VIEWER', 'MINISTER' => 'MINISTERIAL EXECUTIVE OBSERVER',
                'DELEGATION_HEAD', 'DELEGATION HEAD', 'DELEGATION_LEADER', 'HEAD', 'CHEF_DE_DELEGATION', 'DELEGATE', 'COUNTRY_ADMIN', 'ORGANIZER' => 'DELEGATION HEAD',
                'EXPERT', 'JUDGE'            => 'EXPERT JUDGE',
                'VIP', 'OFFICIAL'            => 'VIP DIPLOMATIC',
                'PRESS', 'MEDIA'             => 'MEDIA',
                'SUPERVISOR', 'TEAM_LEADER'  => 'SUPERVISOR',
                default                      => 'COMPETITOR',
            };

            $fullName = trim($delegationMember->first_name . ' ' . $delegationMember->last_name);
            $country = $delegationMember->delegation?->country;

            if ($delegationMember->user) {
                $this->user = $delegationMember->user;
            } else {
                $this->user = new User([
                    'name'       => $fullName,
                    'email'      => $delegationMember->email ?? ($delegationMember->passport_number ?: 'delegate-' . $delegationMember->id),
                    'country_id' => $country?->id,
                ]);
                $this->user->setRelation('country', $country);
            }

            $this->token = $delegationMember->uuid ?? ('WSAP-DEL-' . $delegationMember->id);

            $this->registration = new Registration();
            $p = new ParticipantProfile([
                'first_name_ar'    => $delegationMember->first_name,
                'last_name_ar'     => $delegationMember->last_name,
                'first_name_latin' => $delegationMember->first_name,
                'last_name_latin'  => $delegationMember->last_name,
            ]);
            $this->registration->setRelation('participant', $p);
            $this->registration->setRelation('country', $country);
            $this->registration->setRelation('skill', $delegationMember->skill);
            return;
        }

        // 4. Try finding registration by registration_number or verification_token
        $this->registration = $service->verifyByNumber($identifier) 
            ?? $service->verifyByToken($identifier);

        if ($this->registration) {
            $this->checkRejectionEligibility();
            $this->token = $this->registration->verification_token;
            $this->user  = $this->registration->user;

            $userRole = $this->registration->user?->roles->first()?->name;
            $this->roleTitle = match ($userRole) {
                'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
                'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
                'MEDIA_MANAGER'                     => 'MEDIA',
                'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                default                             => 'COMPETITOR',
            };
            return;
        }

        abort(404, 'بطاقة الاعتماد المطلوب الاستعلام عنها غير موجودة.');
    }


    protected function checkRejectionEligibility()
    {
        if ($this->registration) {
            $st = is_object($this->registration->status) ? ($this->registration->status->value ?? 'APPROVED') : ($this->registration->status ?? 'APPROVED');
            if (strtoupper((string)$st) === 'REJECTED') {
                abort(403, 'بطاقة الاعتماد الرسمية غير متاحة للملفات المرفوضة. يقتصر إصدار الشارة وحق الدخول على المشاركين والمقبولين رسمياً.');
            }
        }
    }

    public function render()
    {
        return view('livewire.public.accreditation-badge');
    }
}
