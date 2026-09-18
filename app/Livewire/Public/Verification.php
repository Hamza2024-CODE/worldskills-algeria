<?php

namespace App\Livewire\Public;

use App\Models\Badge;
use App\Models\DelegationMember;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\RoomAllocation;
use App\Models\User;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout("components.layouts.public")]
class Verification extends Component
{
    public string $query = "";
    public ?Registration $result = null;
    public ?ParticipantProfile $participant = null;
    public ?Badge $badge = null;
    public ?User $verifiedUser = null;
    public ?DelegationMember $delegationMember = null;
    public ?RoomAllocation $accommodation = null;
    public string $lifecycleStatus = "ACTIVE";
    public string $roleTitle = "COMPETITOR";
    public string $nameAr = "";
    public string $nameLatin = "";
    public string $photoUrl = "";
    public string $skillTitle = "";
    public string $countryName = "";
    public string $organizationName = "";
    public string $wilayaName = "";
    public string $badgeCode = "";
    public bool $searched = false;
    public bool $isAuthorizedScanner = false;

    public function mount()
    {
        $user = Auth::user();
        if ($user instanceof User && ($user->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) || $user->canScanQr())) {
            $this->isAuthorizedScanner = true;
        }

        $token = request()->query("token") ?? request()->query("reg") ?? request()->query("identifier") ?? request()->query("code");
        if ($token) {
            $this->query = (string) $token;
            $this->verify();
        }
    }

    public function verify()
    {
        $this->searched = true;
        $this->result = null;
        $this->participant = null;
        $this->badge = null;
        $this->verifiedUser = null;
        $this->delegationMember = null;
        $this->accommodation = null;
        $this->nameAr = "";
        $this->nameLatin = "";
        $this->photoUrl = "";
        $this->skillTitle = "";
        $this->countryName = "";
        $this->organizationName = "";
        $this->wilayaName = "";
        $this->badgeCode = "";

        $clean = trim($this->query);
        if (empty($clean)) {
            return;
        }

        // 1. Extract token from URL if full URL was scanned
        if (filter_var($clean, FILTER_VALIDATE_URL) || str_contains($clean, "http://") || str_contains($clean, "https://")) {
            $parsed = parse_url($clean);
            if (isset($parsed["query"])) {
                parse_str($parsed["query"], $qParams);
                foreach (["token", "reg", "identifier", "code", "id", "uuid"] as $k) {
                    if (!empty($qParams[$k])) {
                        $clean = trim((string) $qParams[$k]);
                        break;
                    }
                }
            }
            if (isset($parsed["path"])) {
                $segments = array_filter(explode("/", rtrim($parsed["path"], "/")));
                $last = end($segments);
                if (!empty($last) && !in_array(strtolower($last), ["verify", "badge", "accreditation", "certificate"])) {
                    $clean = trim($last);
                }
            }
        }

        // 2. Try resolving Badge first by access_token, badge_uuid, or ID
        $this->badge = Badge::with(["user.roles", "user.country", "user.wilaya", "user.organization", "user.participant.registrations.skill"])
            ->where("access_token", $clean)
            ->orWhere("badge_uuid", $clean)
            ->orWhere("id", $clean)
            ->first();

        if ($this->badge) {
            $this->badgeCode = $this->badge->access_token;
            $this->roleTitle = strtoupper($this->badge->role_title ?: "COMPETITOR");
            $user = $this->badge->user;

            if ($user) {
                $this->verifiedUser = $user;
                $this->countryName = $user->country?->name_ar ?? "الجزائر";
                $this->wilayaName = $user->wilaya?->name_ar ?? "";
                $this->organizationName = $user->organization?->name_ar ?? "";

                $reg = Registration::with(["participant.wilaya", "participant.organization", "country", "skill", "organization", "wilaya"])
                    ->whereHas("participant", fn($p) => $p->where("user_id", $user->id))
                    ->latest()
                    ->first();

                if ($reg) {
                    $this->result = $reg;
                    $this->participant = $reg->participant;
                    $this->nameAr = trim(($reg->participant?->first_name_ar ?? "") . " " . ($reg->participant?->last_name_ar ?? ""));
                    $firstLat = $reg->participant?->first_name_fr ?: ($reg->participant?->first_name_en ?: "");
                    $lastLat = $reg->participant?->last_name_fr ?: ($reg->participant?->last_name_en ?: "");
                    $this->nameLatin = trim($firstLat . " " . $lastLat);
                    $this->photoUrl = $reg->photo_url;
                    $this->skillTitle = ($reg->skill?->code ? $reg->skill->code . " — " : "") . ($reg->skill?->name_ar ?? "");
                    if (!$this->wilayaName) $this->wilayaName = $reg->wilaya?->name_ar ?? ($reg->participant?->wilaya?->name_ar ?? "");
                    if (!$this->organizationName) $this->organizationName = $reg->organization?->name_ar ?? ($reg->participant?->organization?->name_ar ?? "");
                } else {
                    $this->nameAr = $user->name;
                    $this->nameLatin = $user->email;
                }

                // Check DelegationMember
                $this->delegationMember = DelegationMember::with(["skill", "delegation.country"])
                    ->where("user_id", $user->id)
                    ->orWhere("email", $user->email)
                    ->first();

                if ($this->delegationMember && !$this->skillTitle && $this->delegationMember->skill) {
                    $this->skillTitle = ($this->delegationMember->skill->code ? $this->delegationMember->skill->code . " — " : "") . $this->delegationMember->skill->name_ar;
                }
            }

            $this->finalizeVerification();
            return;
        }

        // 3. Try resolving by Registration verification_token, uuid, registration_number
        $reg = Registration::with(["participant.user", "participant.wilaya", "participant.organization", "skill", "country", "wilaya", "organization"])
            ->where("verification_token", $clean)
            ->orWhere("registration_number", $clean)
            ->orWhere("uuid", $clean)
            ->first();

        if ($reg) {
            $this->result = $reg;
            $this->participant = $reg->participant;
            $this->badgeCode = $reg->registration_number ?: $reg->verification_token;
            $this->verifiedUser = $reg->user ?: $reg->participant?->user;
            $this->nameAr = trim(($reg->participant?->first_name_ar ?? "") . " " . ($reg->participant?->last_name_ar ?? ""));
            $firstLat = $reg->participant?->first_name_fr ?: ($reg->participant?->first_name_en ?: "");
            $lastLat = $reg->participant?->last_name_fr ?: ($reg->participant?->last_name_en ?: "");
            $this->nameLatin = trim($firstLat . " " . $lastLat);
            $this->photoUrl = $reg->photo_url;
            $this->skillTitle = ($reg->skill?->code ? $reg->skill->code . " — " : "") . ($reg->skill?->name_ar ?? "");
            $this->countryName = $reg->country?->name_ar ?? "الجزائر";
            $this->wilayaName = $reg->wilaya?->name_ar ?? ($reg->participant?->wilaya?->name_ar ?? "");
            $this->organizationName = $reg->organization?->name_ar ?? ($reg->participant?->organization?->name_ar ?? "");
            $this->roleTitle = "COMPETITOR";

            $this->finalizeVerification();
            return;
        }

        // 4. Try resolving User by uuid, id, or email
        $user = User::with(["roles", "country", "wilaya", "organization", "participant.wilaya", "participant.organization", "participant.registrations.skill", "badges"])
            ->where("uuid", $clean)
            ->orWhere("email", $clean)
            ->orWhere("id", $clean)
            ->first();

        if ($user) {
            $this->verifiedUser = $user;
            $this->nameAr = $user->name;
            $this->nameLatin = $user->email;
            $this->countryName = $user->country?->name_ar ?? "الجزائر";
            $this->wilayaName = $user->wilaya?->name_ar ?? "";
            $this->organizationName = $user->organization?->name_ar ?? "";
            $this->badge = $user->badges->first();
            $this->badgeCode = $this->badge?->access_token ?? $user->uuid;

            $reg = $user->participant?->registrations?->first();
            if ($reg) {
                $this->result = $reg;
                $this->participant = $user->participant;
                $this->nameAr = trim(($user->participant?->first_name_ar ?? "") . " " . ($user->participant?->last_name_ar ?? ""));
                $firstLat = $user->participant?->first_name_fr ?: ($user->participant?->first_name_en ?: "");
                $lastLat = $user->participant?->last_name_fr ?: ($user->participant?->last_name_en ?: "");
                $this->nameLatin = trim($firstLat . " " . $lastLat);
                $this->photoUrl = $reg->photo_url;
                $this->skillTitle = ($reg->skill?->code ? $reg->skill->code . " — " : "") . ($reg->skill?->name_ar ?? "");
                if (!$this->wilayaName) $this->wilayaName = $user->participant?->wilaya?->name_ar ?? "";
                if (!$this->organizationName) $this->organizationName = $user->participant?->organization?->name_ar ?? "";
            }

            $userRole = $user->roles->first()?->name;
            $this->roleTitle = match ($userRole) {
                "EXECUTIVE_VIEWER"                  => "MINISTERIAL EXECUTIVE OBSERVER",
                "COUNTRY_ADMIN"                     => "DELEGATION HEAD",
                "MEDIA_MANAGER"                     => "MEDIA",
                "JUDGE", "EXPERT"                   => "EXPERT JUDGE",
                "ORGANIZATION_ADMIN", "SUPER_ADMIN" => "ORGANIZER",
                default                             => "COMPETITOR",
            };

            $this->finalizeVerification();
            return;
        }

        // 5. Try resolving DelegationMember by uuid, passport_number, nin_number, email
        $del = DelegationMember::with(["delegation.country", "skill", "user"])
            ->where("uuid", $clean)
            ->orWhere("passport_number", $clean)
            ->orWhere("nin_number", $clean)
            ->orWhere("email", $clean)
            ->first();

        if ($del) {
            $this->delegationMember = $del;
            $this->nameAr = trim($del->first_name . " " . $del->last_name);
            $this->nameLatin = trim($del->first_name . " " . $del->last_name);
            $this->countryName = $del->delegation?->country?->name_ar ?? "الجزائر";
            $this->badgeCode = $del->uuid ?? ("WSAP-DEL-" . $del->id);
            if ($del->skill) {
                $this->skillTitle = ($del->skill->code ? $del->skill->code . " — " : "") . $del->skill->name_ar;
            }
            $this->roleTitle = match (strtoupper($del->member_type ?? "PARTICIPANT")) {
                "MINISTERIAL_OBSERVER", "MINISTERIAL OBSERVER", "EXECUTIVE_VIEWER", "MINISTER" => "MINISTERIAL EXECUTIVE OBSERVER",
                "DELEGATION_HEAD", "DELEGATION HEAD", "DELEGATION_LEADER", "HEAD", "CHEF_DE_DELEGATION", "DELEGATE", "COUNTRY_ADMIN", "ORGANIZER" => "DELEGATION HEAD",
                "EXPERT", "JUDGE"            => "EXPERT JUDGE",
                "VIP", "OFFICIAL"            => "VIP DIPLOMATIC",
                "PRESS", "MEDIA"             => "MEDIA",
                "SUPERVISOR", "TEAM_LEADER"  => "SUPERVISOR",
                default                      => "COMPETITOR",
            };

            $this->finalizeVerification();
            return;
        }
    }

    protected function finalizeVerification()
    {
        $this->lifecycleStatus = "ACTIVE";

        if (empty($this->nameAr)) {
            $this->nameAr = $this->verifiedUser?->name ?? "عضو معتمد رسمياً";
        }
        if (empty($this->nameLatin)) {
            $this->nameLatin = $this->verifiedUser?->email ?? "Accredited Member";
        }

        $userId = $this->verifiedUser?->id;
        $participantId = $this->result?->participant_id ?? $this->verifiedUser?->participant?->id;

        if ($userId) {
            $this->accommodation = RoomAllocation::with(["room.accommodation"])
                ->where("user_id", $userId)
                ->first();
        }
        if (!$this->accommodation && $participantId) {
            $this->accommodation = RoomAllocation::with(["room.accommodation"])
                ->where("participant_profile_id", $participantId)
                ->first();
        }
    }

    public function render()
    {
        return view("livewire.public.verification");
    }
}
