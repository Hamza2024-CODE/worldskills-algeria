<?php

namespace App\Livewire\Country;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\DelegationMember;
use App\Models\Edition;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class DietaryManager extends Component
{
    public ?Edition $edition = null;
    public ?Country $country = null;
    public ?CountryDelegation $delegation = null;

    // Filters
    public string $searchQuery = '';
    public string $selectedRole = 'ALL';
    public string $selectedAllergyFilter = 'ALL';

    // Modal Edit State
    public bool $showEditModal = false;
    public ?int $editingMemberId = null;
    public ?DelegationMember $editingMember = null;

    // Form fields
    public array $memberDietaryRequirements = [];
    public string $memberDietaryNotes = '';

    public string $flashMessage = '';

    public function mount()
    {
        $user = Auth::user();
        $this->edition = Edition::where('is_active', true)->first() ?? Edition::latest()->first();

        if ($user && $user->country_id) {
            $this->country = Country::find($user->country_id);
        } elseif ($user && $user->delegationMember && $user->delegationMember->delegation) {
            $this->country = $user->delegationMember->delegation->country;
        } else {
            $this->country = Country::where('iso3', 'DZA')->orWhere('iso2', 'DZ')->first();
        }

        if ($this->country && $this->edition) {
            $this->delegation = CountryDelegation::firstOrCreate([
                'edition_id' => $this->edition->id,
                'country_id' => $this->country->id,
            ]);
        }
    }

    public function openEditModal(int $memberId)
    {
        $member = DelegationMember::find($memberId);
        if (!$member) return;

        $this->editingMemberId = $member->id;
        $this->editingMember = $member;
        $this->memberDietaryRequirements = is_array($member->dietary_requirements) ? $member->dietary_requirements : [];
        $this->memberDietaryNotes = $member->dietary_notes ?? '';
        $this->showEditModal = true;
    }

    public function saveDietaryInfo()
    {
        if (!$this->editingMemberId) return;

        $member = DelegationMember::find($this->editingMemberId);
        if ($member) {
            $member->update([
                'dietary_requirements' => array_values(array_unique($this->memberDietaryRequirements)),
                'dietary_notes'        => trim($this->memberDietaryNotes),
            ]);

            $this->flashMessage = __('messages.success') ?? 'تم تحديث البيانات الغذائية والحساسية بنجاح';
        }

        $this->showEditModal = false;
        $this->editingMemberId = null;
        $this->editingMember = null;
    }

    public function toggleRequirement(string $code)
    {
        if (in_array($code, $this->memberDietaryRequirements)) {
            $this->memberDietaryRequirements = array_values(array_filter(
                $this->memberDietaryRequirements,
                fn($item) => $item !== $code
            ));
        } else {
            $this->memberDietaryRequirements[] = $code;
        }
    }

    public function render()
    {
        $membersQuery = DelegationMember::with(['skill', 'user'])
            ->where('delegation_id', $this->delegation?->id);

        if (!empty($this->searchQuery)) {
            $queryStr = '%' . trim($this->searchQuery) . '%';
            $membersQuery->where(function ($q) use ($queryStr) {
                $q->where('first_name', 'like', $queryStr)
                  ->orWhere('last_name', 'like', $queryStr)
                  ->orWhere('passport_number', 'like', $queryStr)
                  ->orWhere('email', 'like', $queryStr);
            });
        }

        if ($this->selectedRole !== 'ALL') {
            $membersQuery->where('member_type', $this->selectedRole);
        }

        $allMembers = (clone $membersQuery)->get();

        if ($this->selectedAllergyFilter !== 'ALL') {
            if ($this->selectedAllergyFilter === 'HAS_ALLERGY') {
                $allMembers = $allMembers->filter(fn($m) => !empty($m->dietary_requirements) || !empty($m->dietary_notes));
            } else {
                $allMembers = $allMembers->filter(fn($m) => is_array($m->dietary_requirements) && in_array($this->selectedAllergyFilter, $m->dietary_requirements));
            }
        }

        // Calculate statistics
        $totalMembers = DelegationMember::where('delegation_id', $this->delegation?->id)->count();
        $membersWithAllergiesCount = DelegationMember::where('delegation_id', $this->delegation?->id)
            ->where(function ($q) {
                $q->whereNotNull('dietary_requirements')->orWhereNotNull('dietary_notes');
            })->count();

        $allergyBreakdown = [
            'GLUTEN_FREE'    => 0,
            'LACTOSE_FREE'   => 0,
            'NUT_ALLERGY'    => 0,
            'SEAFOOD_ALLERGY'=> 0,
            'HALAL_ONLY'     => 0,
            'VEGETARIAN'     => 0,
            'VEGAN'          => 0,
            'DIABETIC'       => 0,
        ];

        $rawMembers = DelegationMember::where('delegation_id', $this->delegation?->id)->get();
        foreach ($rawMembers as $m) {
            if (is_array($m->dietary_requirements)) {
                foreach ($m->dietary_requirements as $req) {
                    if (isset($allergyBreakdown[$req])) {
                        $allergyBreakdown[$req]++;
                    }
                }
            }
        }

        return view('livewire.country.dietary-manager', [
            'members'                   => $allMembers,
            'totalMembers'              => $totalMembers,
            'membersWithAllergiesCount' => $membersWithAllergiesCount,
            'allergyBreakdown'          => $allergyBreakdown,
        ]);
    }
}
