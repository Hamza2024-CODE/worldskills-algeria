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

        // 1. Evaluate access rules via central rules engine
        $this->accessDecision = $rulesEngine->evaluateAccess($clean);
        $this->scannedBadge   = $this->accessDecision['badge'] ?? null;
        $this->scannedUser    = $this->accessDecision['user'] ?? null;

        // 2. Resolve DelegationMember
        if ($this->scannedUser) {
            $this->delegationMember = DelegationMember::with(['skill', 'delegation.country', 'user'])
                ->where('user_id', $this->scannedUser->id)
                ->orWhere('email', $this->scannedUser->email)
                ->first();
        }

        if (!$this->delegationMember) {
            $this->delegationMember = DelegationMember::with(['skill', 'delegation.country', 'user'])
                ->where('uuid', $clean)
                ->orWhere('id', $clean)
                ->orWhere('email', $clean)
                ->orWhere('passport_number', $clean)
                ->orWhere('nin_number', $clean)
                ->first();

            if ($this->delegationMember && !$this->scannedUser) {
                if ($this->delegationMember->user) {
                    $this->scannedUser = $this->delegationMember->user;
                } elseif (!empty($this->delegationMember->email)) {
                    $this->scannedUser = User::where('email', $this->delegationMember->email)->first();
                }
            }
        }

        // 3. Fallback User resolution if still null
        if (!$this->scannedUser) {
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
        }

        if ($this->scannedUser) {
            $this->scannedUser->loadMissing([
                'roles',
                'country',
                'wilaya',
                'organization',
                'participant.registrations.skill',
                'participant.registrations.country',
            ]);
        }

        // 4. Resolve Registration
        if ($this->scannedUser?->participant) {
            $this->registration = Registration::with(['skill', 'country'])
                ->where('participant_id', $this->scannedUser->participant->id)
                ->latest()
                ->first();
        }

        if (!$this->registration) {
            $emailToSearch = $this->delegationMember?->email ?: $this->scannedUser?->email;
            if ($emailToSearch) {
                $this->registration = Registration::with(['skill', 'country'])
                    ->whereHas('participant.user', function($q) use ($emailToSearch) {
                        $q->where('email', $emailToSearch);
                    })
                    ->latest()
                    ->first();
            }
        }

        // 5. Resolve Room Allocation & Accommodation
        if ($this->scannedUser) {
            $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                ->where('user_id', $this->scannedUser->id)
                ->first();

            if (!$this->roomAllocation && $this->scannedUser->participant) {
                $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                    ->where('participant_profile_id', $this->scannedUser->participant->id)
                    ->first();
            }
        }

        if (!$this->roomAllocation && $this->delegationMember?->email) {
            $allocUser = User::where('email', $this->delegationMember->email)->first();
            if ($allocUser) {
                $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                    ->where('user_id', $allocUser->id)
                    ->first();
            }
        }

        // 6. Resolve Badge if missing
        if (!$this->scannedBadge && $this->scannedUser) {
            $this->scannedBadge = Badge::where('user_id', $this->scannedUser->id)->first();
        }

        // 7. Security Zone Permissions
        if ($this->scannedBadge) {
            $this->zonePermissions = BadgeZonePermission::with('zone')
                ->where('badge_id', $this->scannedBadge->id)
                ->get()
                ->toArray();
        }

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
