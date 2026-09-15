<?php

namespace App\Livewire\Country;

use App\Enums\MemberType;
use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\CountrySkillSelection;
use App\Models\DelegationMember;
use App\Models\Edition;
use App\Models\Skill;
use App\Models\TechnicalAppeal;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class CountryDashboard extends Component
{
    public ?Edition $edition = null;
    public ?Country $country = null;
    public ?CountryDelegation $delegation = null;

    // Role KPI Counters
    public int $totalDelegationMembers = 0;
    public int $participantsCount = 0;
    public int $judgesCount = 0;
    public int $pressCount = 0;
    public int $supervisorsCount = 0;
    public int $vipCount = 0;
    public int $expertsCount = 0;
    public int $selectedSkillsCount = 0;

    // Search and Filters
    public string $search = '';
    public string $filterRole = 'ALL';
    public string $filterStatus = 'ALL';
    public string $flashMessage = '';

    // Active Tab for Dashboard (Roster vs Appeals vs Regulations)
    public string $activeTab = 'roster';

    // Add / Edit Member Modal State
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showViewModal = false;
    public bool $showAppealModal = false;

    public ?int $editingMemberId = null;
    public ?DelegationMember $viewingMember = null;

    // Member Form Fields
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $memberType = 'PARTICIPANT';
    public ?int $skillId = null;
    public string $passportNumber = '';
    public string $ninNumber = '';
    public string $gender = 'male';
    public string $suitSize = '';
    public string $shoeSize = '';
    public string $status = 'APPROVED';

    // Appeal Form Fields
    public ?int $appealSkillId = null;
    public string $appealSubject = '';
    public string $appealDescription = '';
    public string $appealPriority = 'MEDIUM';

    public function mount(?int $targetCountryId = null): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->country_id) {
            if ($targetCountryId && $targetCountryId !== $user->country_id && !$user->hasRole('SUPER_ADMIN')) {
                throw new AuthorizationException('Cross-country IDOR access denied.');
            }
            $this->country = Country::find($user->country_id);
        } else {
            $this->country = Country::where('iso2', 'DZ')->first() ?? Country::first();
        }

        $this->edition = Edition::where('is_active', true)->first();

        if (request()->routeIs('country.appeals')) {
            $this->activeTab = 'appeals';
        }

        $this->loadMetrics();
    }

    public function loadMetrics(): void
    {
        if ($this->edition && $this->country) {
            $this->delegation = CountryDelegation::firstOrCreate([
                'edition_id' => $this->edition->id,
                'country_id' => $this->country->id,
            ], [
                'status' => 'APPROVED',
            ]);

            $selections = CountrySkillSelection::where('edition_id', $this->edition->id)
                ->where('country_id', $this->country->id)
                ->get();

            $this->selectedSkillsCount = $selections->count();

            if ($this->delegation) {
                $membersQuery = $this->delegation->members();

                $this->totalDelegationMembers = (clone $membersQuery)->count();
                $this->participantsCount       = (clone $membersQuery)->where('member_type', 'PARTICIPANT')->count();
                $this->judgesCount             = (clone $membersQuery)->where('member_type', 'JUDGE')->count();
                $this->pressCount              = (clone $membersQuery)->where('member_type', 'PRESS')->count();
                $this->supervisorsCount        = (clone $membersQuery)->where('member_type', 'SUPERVISOR')->count();
                $this->vipCount                = (clone $membersQuery)->where('member_type', 'VIP')->count();
                $this->expertsCount            = (clone $membersQuery)->where('member_type', 'EXPERT')->count();
            }
        }
    }

    public function openAddModal(): void
    {
        $this->resetInputFields();
        $this->showAddModal = true;
    }

    public function addMember(): void
    {
        $this->validate([
            'firstName'  => 'required|string|min:2',
            'lastName'   => 'required|string|min:2',
            'memberType' => 'required|string',
            'gender'     => 'required|string',
        ]);

        if (!$this->delegation) return;

        /** @var \App\Services\DocumentVerificationService $docVerifier */
        $docVerifier = app(\App\Services\DocumentVerificationService::class);

        // Strict Uniqueness Check for Email, Phone, NIN, and Passport
        $check = $docVerifier->checkIdentityUniqueness(
            $this->ninNumber,
            $this->passportNumber,
            $this->email,
            $this->phone
        );

        if (!$check['is_valid']) {
            foreach ($check['errors'] as $field => $msg) {
                if ($field === 'email') $this->addError('email', $msg);
                if ($field === 'phone') $this->addError('phone', $msg);
                if ($field === 'nin') $this->addError('ninNumber', $msg);
                if ($field === 'passport') $this->addError('passportNumber', $msg);
            }
            return;
        }

        DelegationMember::create([
            'delegation_id'   => $this->delegation->id,
            'member_type'     => $this->memberType,
            'skill_id'        => $this->skillId,
            'first_name'      => $this->firstName,
            'last_name'       => $this->lastName,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'passport_number' => $this->passportNumber,
            'nin_number'      => $this->ninNumber,
            'gender'          => $this->gender,
            'suit_size'       => $this->suitSize,
            'shoe_size'       => $this->shoeSize,
            'status'          => $this->status,
        ]);

        $this->resetInputFields();
        $this->showAddModal = false;
        $this->flashMessage = 'تمت إضافة العضو بنجاح وتحديث كشف الوفد.';
        $this->loadMetrics();
    }

    public function editMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if (!$member) return;

        $this->editingMemberId = $member->id;
        $this->firstName       = $member->first_name;
        $this->lastName        = $member->last_name;
        $this->email           = $member->email ?? '';
        $this->phone           = $member->phone ?? '';
        $this->memberType      = $member->member_type;
        $this->skillId         = $member->skill_id;
        $this->passportNumber  = $member->passport_number ?? '';
        $this->ninNumber       = $member->nin_number ?? '';
        $this->gender          = $member->gender ?? 'male';
        $this->suitSize        = $member->suit_size ?? '';
        $this->shoeSize        = $member->shoe_size ?? '';
        $this->status          = $member->status ?? 'APPROVED';

        $this->showEditModal = true;
    }

    public function updateMember(): void
    {
        $member = DelegationMember::find($this->editingMemberId);
        if (!$member) return;

        /** @var \App\Services\DocumentVerificationService $docVerifier */
        $docVerifier = app(\App\Services\DocumentVerificationService::class);

        // Strict Uniqueness Check for Email, Phone, NIN, and Passport
        $check = $docVerifier->checkIdentityUniqueness(
            $this->ninNumber,
            $this->passportNumber,
            $this->email,
            $this->phone,
            $this->editingMemberId
        );

        if (!$check['is_valid']) {
            foreach ($check['errors'] as $field => $msg) {
                if ($field === 'email') $this->addError('email', $msg);
                if ($field === 'phone') $this->addError('phone', $msg);
                if ($field === 'nin') $this->addError('ninNumber', $msg);
                if ($field === 'passport') $this->addError('passportNumber', $msg);
            }
            return;
        }

        $member->update([
            'member_type'     => $this->memberType,
            'skill_id'        => $this->skillId,
            'first_name'      => $this->firstName,
            'last_name'       => $this->lastName,
            'email'           => $this->email,
            'phone'           => $this->phone,
            'passport_number' => $this->passportNumber,
            'nin_number'      => $this->ninNumber,
            'gender'          => $this->gender,
            'suit_size'       => $this->suitSize,
            'shoe_size'       => $this->shoeSize,
            'status'          => $this->status,
        ]);

        $this->showEditModal = false;
        $this->resetInputFields();
        $this->flashMessage = 'تم تحديث بيانات العضو بنجاح.';
        $this->loadMetrics();
    }

    public function approveMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if ($member) {
            $member->update(['status' => 'APPROVED']);
            $this->flashMessage = 'تم اعتماد وعرض عضو الوفد بنجاح.';
            $this->loadMetrics();
        }
    }

    public function rejectMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if ($member) {
            $member->update(['status' => 'REJECTED']);
            $this->flashMessage = 'تم تغيير حالة العضو إلى مرفوض.';
            $this->loadMetrics();
        }
    }

    public function removeMember(int $memberId): void
    {
        DelegationMember::where('id', $memberId)->delete();
        $this->flashMessage = 'تم إزالة العضو من الوفد.';
        $this->loadMetrics();
    }

    public function viewMemberDetails(int $memberId): void
    {
        $this->viewingMember = DelegationMember::with(['skill', 'delegation.country'])->find($memberId);
        if ($this->viewingMember) {
            $this->showViewModal = true;
        }
    }

    public function submitTechnicalAppeal(): void
    {
        $this->validate([
            'appealSkillId'     => 'required|exists:skills,id',
            'appealSubject'     => 'required|string|min:5',
            'appealDescription' => 'required|string|min:10',
        ]);

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        TechnicalAppeal::create([
            'skill_id'              => $this->appealSkillId,
            'submitted_by_user_id'  => $user?->id,
            'subject'               => $this->appealSubject,
            'description'           => $this->appealDescription,
            'priority'              => $this->appealPriority,
            'status'                => 'SUBMITTED',
            'submitted_at'          => now(),
        ]);

        $this->appealSkillId = null;
        $this->appealSubject = '';
        $this->appealDescription = '';
        $this->showAppealModal = false;
        $this->flashMessage = 'تم تقديم الطعن الفني بنجاح وتسجيله في سجل التظلمات.';
    }

    private function resetInputFields(): void
    {
        $this->editingMemberId = null;
        $this->firstName       = '';
        $this->lastName        = '';
        $this->email           = '';
        $this->phone           = '';
        $this->memberType      = 'PARTICIPANT';
        $this->skillId         = null;
        $this->passportNumber  = '';
        $this->ninNumber       = '';
        $this->gender          = 'male';
        $this->suitSize        = '';
        $this->shoeSize        = '';
        $this->status          = 'APPROVED';
    }

    public function render()
    {
        $this->loadMetrics();

        $query = $this->delegation ? $this->delegation->members()->with('skill') : DelegationMember::query()->whereRaw('1=0');

        if ($this->filterRole !== 'ALL') {
            $query->where('member_type', $this->filterRole);
        }

        if ($this->filterStatus !== 'ALL') {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->search)) {
            $s = '%' . $this->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('passport_number', 'like', $s)
                  ->orWhere('nin_number', 'like', $s);
            });
        }

        $members = $query->orderBy('id', 'desc')->get();
        $skills  = Skill::where('is_active', true)->orderBy('sort_order')->get();
        $appeals = TechnicalAppeal::with(['skill', 'submittedBy', 'decision'])->orderBy('id', 'desc')->get();

        return view('livewire.country.country-dashboard', [
            'members' => $members,
            'skills'  => $skills,
            'appeals' => $appeals,
        ]);
    }
}
