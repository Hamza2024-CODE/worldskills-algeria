<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\DelegationMember;
use App\Models\RoomAllocation;
use App\Models\User;
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
    public ?RoomAllocation   $roomAllocation     = null;
    public array             $zonePermissions    = [];
    public array             $accessDecision     = [];
    public bool              $showOverrideModal  = false;
    public string            $overrideReasonAr   = '';

    public function scan(WsapAccessRulesEngine $rulesEngine): void
    {
        $this->scannedUser      = null;
        $this->scannedBadge     = null;
        $this->delegationMember = null;
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
            // Fallback user lookup by email, uuid, or ID
            $this->scannedUser = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])
                ->where('email', $clean)
                ->orWhere('uuid', $clean)
                ->orWhere('id', $clean)
                ->first();
        } else {
            // Ensure full relations loaded
            $this->scannedUser->loadMissing(['roles', 'country', 'wilaya', 'organization', 'participant.registrations']);
        }

        if ($this->scannedUser) {
            // Load delegation member profile
            $this->delegationMember = DelegationMember::with(['skill', 'delegation.country'])
                ->where('user_id', $this->scannedUser->id)
                ->orWhere('email', $this->scannedUser->email)
                ->first();

            // Load room allocation & hotel details
            $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                ->where('user_id', $this->scannedUser->id)
                ->first();

            if (!$this->roomAllocation && $this->scannedUser->participant) {
                $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                    ->where('participant_profile_id', $this->scannedUser->participant->id)
                    ->first();
            }
        }

        if ($this->scannedBadge) {
            $this->zonePermissions = BadgeZonePermission::with('zone')
                ->where('badge_id', $this->scannedBadge->id)
                ->get()
                ->toArray();

            if (empty($this->zonePermissions)) {
                $allowedIds = $this->scannedBadge->allowed_zone_ids ?? [1, 2, 3, 4, 5];
                $zones = \App\Models\Zone::whereIn('id', $allowedIds)->get();
                foreach ($zones as $z) {
                    $this->zonePermissions[] = [
                        'zone_id'    => $z->id,
                        'permission' => 'ALLOW',
                        'zone'       => $z->toArray(),
                    ];
                }
            }
        }
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
