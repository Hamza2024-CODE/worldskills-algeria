<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\DelegationMember;
use App\Models\Edition;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.dashboard.app-shell')]
class AdminDietaryIndex extends Component
{
    use WithPagination;

    // Filters & Search
    public string $searchQuery = '';
    public string $selectedCountryId = 'ALL';
    public string $selectedRole = 'ALL';
    public string $selectedAllergyFilter = 'ALL';
    public int $perPage = 15;

    // Flash Messages
    public string $flashMessage = '';
    public string $flashMessageType = 'success';

    // EDIT Modal State
    public bool $showEditModal = false;
    public ?int $editingMemberId = null;
    public string $editFirstName = '';
    public string $editLastName = '';
    public string $editMemberType = 'COMPETITOR';
    public ?int $editCountryId = null;
    public string $editPassport = '';
    public string $editEmail = '';
    public string $editPhone = '';
    public array $memberDietaryRequirements = [];
    public string $memberDietaryNotes = '';

    // ADD Modal State
    public bool $showAddModal = false;
    public string $addFirstName = '';
    public string $addLastName = '';
    public string $addMemberType = 'COMPETITOR';
    public ?int $addCountryId = null;
    public string $addGender = 'MALE';
    public string $addPassport = '';
    public string $addEmail = '';
    public string $addPhone = '';
    public array $addDietaryRequirements = [];
    public string $addDietaryNotes = '';

    // DELETE / CLEAR Modal State
    public bool $showDeleteModal = false;
    public ?int $deletingMemberId = null;
    public string $deletingMemberName = '';
    public string $deleteActionType = 'DELETE_MEMBER'; // 'DELETE_MEMBER' or 'CLEAR_DIETARY'

    // PRINT MODAL VIEWS
    public bool $showCardsPrintModal = false;

    public function updatingSearchQuery() { $this->resetPage(); }
    public function updatingSelectedCountryId() { $this->resetPage(); }
    public function updatingSelectedRole() { $this->resetPage(); }
    public function updatingSelectedAllergyFilter() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); }

    public static function getDietaryOptions(): array
    {
        return [
            'HALAL_ONLY' => [
                'code'      => 'HALAL_ONLY',
                'label_ar'  => 'طعام حلال فقط',
                'label_fr'  => 'Halal Uniquement',
                'label_en'  => 'Halal Only',
                'style'     => 'bg-emerald-50 text-emerald-900 border-emerald-300 dark:bg-emerald-950/40 dark:text-emerald-200 dark:border-emerald-800',
                'badge'     => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-900/60 dark:text-emerald-200 dark:border-emerald-800',
            ],
            'GLUTEN_FREE' => [
                'code'      => 'GLUTEN_FREE',
                'label_ar'  => 'خالي من الغلوتين (سيلياك)',
                'label_fr'  => 'Sans Gluten (Cœliaque)',
                'label_en'  => 'Gluten-Free (Celiac)',
                'style'     => 'bg-amber-50 text-amber-900 border-amber-300 dark:bg-amber-950/40 dark:text-amber-200 dark:border-amber-800',
                'badge'     => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-900/60 dark:text-amber-200 dark:border-amber-800',
            ],
            'LACTOSE_FREE' => [
                'code'      => 'LACTOSE_FREE',
                'label_ar'  => 'خالي من اللكتوز (مشتقات الحليب)',
                'label_fr'  => 'Sans Lactose',
                'label_en'  => 'Lactose-Free',
                'style'     => 'bg-sky-50 text-sky-900 border-sky-300 dark:bg-sky-950/40 dark:text-sky-200 dark:border-sky-800',
                'badge'     => 'bg-sky-100 text-sky-800 border-sky-300 dark:bg-sky-900/60 dark:text-sky-200 dark:border-sky-800',
            ],
            'NUT_ALLERGY' => [
                'code'      => 'NUT_ALLERGY',
                'label_ar'  => 'حساسية المكسرات والفول السوداني',
                'label_fr'  => 'Allergie Fruits à Coque / Arachides',
                'label_en'  => 'Nut & Peanut Allergy',
                'style'     => 'bg-rose-50 text-rose-900 border-rose-300 dark:bg-rose-950/40 dark:text-rose-200 dark:border-rose-800',
                'badge'     => 'bg-rose-100 text-rose-800 border-rose-300 dark:bg-rose-900/60 dark:text-rose-200 dark:border-rose-800',
            ],
            'SEAFOOD_ALLERGY' => [
                'code'      => 'SEAFOOD_ALLERGY',
                'label_ar'  => 'حساسية الأسماك والمأكولات البحرية',
                'label_fr'  => 'Allergie Poissons & Crustacés',
                'label_en'  => 'Seafood & Shellfish Allergy',
                'style'     => 'bg-cyan-50 text-cyan-900 border-cyan-300 dark:bg-cyan-950/40 dark:text-cyan-200 dark:border-cyan-800',
                'badge'     => 'bg-cyan-100 text-cyan-800 border-cyan-300 dark:bg-cyan-900/60 dark:text-cyan-200 dark:border-cyan-800',
            ],
            'VEGETARIAN' => [
                'code'      => 'VEGETARIAN',
                'label_ar'  => 'نباتي (Vegetarian)',
                'label_fr'  => 'Végétarien',
                'label_en'  => 'Vegetarian',
                'style'     => 'bg-lime-50 text-lime-900 border-lime-300 dark:bg-lime-950/40 dark:text-lime-200 dark:border-lime-800',
                'badge'     => 'bg-lime-100 text-lime-800 border-lime-300 dark:bg-lime-900/60 dark:text-lime-200 dark:border-lime-800',
            ],
            'VEGAN' => [
                'code'      => 'VEGAN',
                'label_ar'  => 'نباتي تام (Vegan)',
                'label_fr'  => 'Végétalien / Vegan',
                'label_en'  => 'Vegan',
                'style'     => 'bg-green-50 text-green-900 border-green-300 dark:bg-green-950/40 dark:text-green-200 dark:border-green-800',
                'badge'     => 'bg-green-100 text-green-800 border-green-300 dark:bg-green-900/60 dark:text-green-200 dark:border-green-800',
            ],
            'DIABETIC' => [
                'code'      => 'DIABETIC',
                'label_ar'  => 'حمية داء السكري (بدون سكر)',
                'label_fr'  => 'Régime Diabétique',
                'label_en'  => 'Diabetic Friendly',
                'style'     => 'bg-purple-50 text-purple-900 border-purple-300 dark:bg-purple-950/40 dark:text-purple-200 dark:border-purple-800',
                'badge'     => 'bg-purple-100 text-purple-800 border-purple-300 dark:bg-purple-900/60 dark:text-purple-200 dark:border-purple-800',
            ],
            'EGG_ALLERGY' => [
                'code'      => 'EGG_ALLERGY',
                'label_ar'  => 'حساسية البيض',
                'label_fr'  => 'Allergie aux Œufs',
                'label_en'  => 'Egg Allergy',
                'style'     => 'bg-yellow-50 text-yellow-900 border-yellow-300 dark:bg-yellow-950/40 dark:text-yellow-200 dark:border-yellow-800',
                'badge'     => 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-900/60 dark:text-yellow-200 dark:border-yellow-800',
            ],
            'SOY_ALLERGY' => [
                'code'      => 'SOY_ALLERGY',
                'label_ar'  => 'حساسية الصويا',
                'label_fr'  => 'Allergie au Soja',
                'label_en'  => 'Soy Allergy',
                'style'     => 'bg-stone-50 text-stone-900 border-stone-300 dark:bg-stone-950/40 dark:text-stone-200 dark:border-stone-800',
                'badge'     => 'bg-stone-100 text-stone-800 border-stone-300 dark:bg-stone-900/60 dark:text-stone-200 dark:border-stone-800',
            ],
        ];
    }

    // --- ADD MEMBER & DIETARY RECORD ---
    public function openAddModal(): void
    {
        $this->addFirstName = '';
        $this->addLastName = '';
        $this->addMemberType = 'COMPETITOR';
        $this->addGender = 'MALE';
        $this->addPassport = '';
        $this->addEmail = '';
        $this->addPhone = '';
        $this->addDietaryRequirements = [];
        $this->addDietaryNotes = '';

        $firstCountry = Country::orderBy('name_ar')->first();
        $this->addCountryId = $firstCountry?->id;

        $this->showAddModal = true;
    }

    public function toggleAddRequirement(string $code): void
    {
        if (in_array($code, $this->addDietaryRequirements)) {
            $this->addDietaryRequirements = array_values(array_filter(
                $this->addDietaryRequirements,
                fn($item) => $item !== $code
            ));
        } else {
            $this->addDietaryRequirements[] = $code;
        }
    }

    public function createMemberDietary(): void
    {
        $this->validate([
            'addFirstName' => 'required|string|max:100',
            'addLastName'  => 'required|string|max:100',
            'addCountryId' => 'required|integer|exists:countries,id',
            'addMemberType'=> 'required|string',
        ]);

        $activeEdition = Edition::first();
        $editionId = $activeEdition?->id ?? 1;

        $delegation = CountryDelegation::firstOrCreate(
            [
                'country_id' => $this->addCountryId,
                'edition_id' => $editionId,
            ],
            [
                'status' => 'ACTIVE',
            ]
        );

        $member = DelegationMember::create([
            'delegation_id'        => $delegation->id,
            'first_name'           => trim($this->addFirstName),
            'last_name'            => trim($this->addLastName),
            'member_type'          => $this->addMemberType,
            'gender'               => $this->addGender,
            'passport_number'      => trim($this->addPassport),
            'email'                => trim($this->addEmail),
            'phone'                => trim($this->addPhone),
            'dietary_requirements' => array_values(array_unique($this->addDietaryRequirements)),
            'dietary_notes'        => trim($this->addDietaryNotes),
            'status'               => 'APPROVED',
        ]);

        $this->flashMessage = 'تمت إضافة السجل والبيانات الغذائية بنجاح للمشارك: ' . $member->full_name;
        $this->flashMessageType = 'success';
        $this->showAddModal = false;
    }

    // --- EDIT MEMBER & DIETARY RECORD ---
    public function openEditModal(int $memberId): void
    {
        $member = DelegationMember::with(['delegation.country'])->find($memberId);
        if (!$member) return;

        $this->editingMemberId = $member->id;
        $this->editFirstName = $member->first_name ?? '';
        $this->editLastName = $member->last_name ?? '';
        $this->editMemberType = $member->member_type ?? 'COMPETITOR';
        $this->editCountryId = $member->delegation?->country_id;
        $this->editPassport = $member->passport_number ?? '';
        $this->editEmail = $member->email ?? '';
        $this->editPhone = $member->phone ?? '';

        $this->memberDietaryRequirements = is_array($member->dietary_requirements) ? $member->dietary_requirements : [];
        $this->memberDietaryNotes = $member->dietary_notes ?? '';

        $this->showEditModal = true;
    }

    public function toggleRequirement(string $code): void
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

    public function saveDietaryInfo(): void
    {
        if (!$this->editingMemberId) return;

        $this->validate([
            'editFirstName' => 'required|string|max:100',
            'editLastName'  => 'required|string|max:100',
            'editCountryId' => 'required|integer|exists:countries,id',
            'editMemberType'=> 'required|string',
        ]);

        $member = DelegationMember::find($this->editingMemberId);
        if ($member) {
            if ($this->editCountryId && $member->delegation?->country_id != $this->editCountryId) {
                $activeEdition = Edition::first();
                $editionId = $activeEdition?->id ?? 1;

                $delegation = CountryDelegation::firstOrCreate(
                    [
                        'country_id' => $this->editCountryId,
                        'edition_id' => $editionId,
                    ],
                    [
                        'status' => 'ACTIVE',
                    ]
                );
                $member->delegation_id = $delegation->id;
            }

            $member->update([
                'first_name'           => trim($this->editFirstName),
                'last_name'            => trim($this->editLastName),
                'member_type'          => $this->editMemberType,
                'passport_number'      => trim($this->editPassport),
                'email'                => trim($this->editEmail),
                'phone'                => trim($this->editPhone),
                'dietary_requirements' => array_values(array_unique($this->memberDietaryRequirements)),
                'dietary_notes'        => trim($this->memberDietaryNotes),
            ]);

            $this->flashMessage = 'تم تحديث بيانات الحساسية والاحتياجات الغذائية بنجاح للمشارك: ' . $member->full_name;
            $this->flashMessageType = 'success';
        }

        $this->showEditModal = false;
        $this->editingMemberId = null;
    }

    // --- DELETE / CLEAR CONFIRMATION ---
    public function confirmDelete(int $memberId, string $actionType = 'DELETE_MEMBER'): void
    {
        $member = DelegationMember::find($memberId);
        if (!$member) return;

        $this->deletingMemberId = $member->id;
        $this->deletingMemberName = $member->full_name;
        $this->deleteActionType = $actionType;
        $this->showDeleteModal = true;
    }

    public function executeDeleteAction(): void
    {
        if (!$this->deletingMemberId) return;

        $member = DelegationMember::find($this->deletingMemberId);
        if ($member) {
            if ($this->deleteActionType === 'CLEAR_DIETARY') {
                $member->update([
                    'dietary_requirements' => null,
                    'dietary_notes'        => null,
                ]);
                $this->flashMessage = 'تم مسح وتفريغ سجل الحساسية بنجاح للمشارك: ' . $this->deletingMemberName;
                $this->flashMessageType = 'warning';
            } else {
                $member->delete();
                $this->flashMessage = 'تم حذف سجل المشارك بالكامل من قاعدة البيانات: ' . $this->deletingMemberName;
                $this->flashMessageType = 'danger';
            }
        }

        $this->showDeleteModal = false;
        $this->deletingMemberId = null;
        $this->deletingMemberName = '';
    }

    // --- CSV EXPORT ---
    public function exportDietaryCsv(): StreamedResponse
    {
        $query = DelegationMember::with(['delegation.country', 'skill']);
        $this->applyFilters($query);
        $members = $query->orderBy('first_name')->get();

        $dietaryOptions = self::getDietaryOptions();

        $filename = 'dietary_report_' . date('Y-m-d_H-i-s') . '.csv';

        return response()->streamDownload(function () use ($members, $dietaryOptions) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "ï»¿");

            fputcsv($handle, [
                'ID',
                'Full Name',
                'Country / Delegation',
                'Role / Type',
                'Passport Number',
                'Dietary Requirements',
                'Medical / Special Notes',
                'Email',
                'Phone',
            ]);

            foreach ($members as $m) {
                $requirements = [];
                if (is_array($m->dietary_requirements)) {
                    foreach ($m->dietary_requirements as $req) {
                        $requirements[] = $dietaryOptions[$req]['label_ar'] ?? $req;
                    }
                }

                fputcsv($handle, [
                    $m->id,
                    $m->full_name,
                    $m->delegation?->country?->name_ar ?? 'غير محدد',
                    $m->member_type,
                    $m->passport_number ?? '—',
                    implode(' | ', $requirements),
                    $m->dietary_notes ?? '—',
                    $m->email ?? '—',
                    $m->phone ?? '—',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function applyFilters($query): void
    {
        if (!empty($this->searchQuery)) {
            $s = '%' . trim($this->searchQuery) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('passport_number', 'like', $s)
                  ->orWhere('email', 'like', $s)
                  ->orWhere('dietary_notes', 'like', $s);
            });
        }

        if ($this->selectedCountryId !== 'ALL') {
            $query->whereHas('delegation', function ($q) {
                $q->where('country_id', $this->selectedCountryId);
            });
        }

        if ($this->selectedRole !== 'ALL') {
            $query->where('member_type', $this->selectedRole);
        }

        if ($this->selectedAllergyFilter !== 'ALL') {
            if ($this->selectedAllergyFilter === 'HAS_ALLERGY') {
                $query->where(function ($q) {
                    $q->whereNotNull('dietary_requirements')
                      ->where('dietary_requirements', '!=', '[]')
                      ->orWhereNotNull('dietary_notes');
                });
            } elseif ($this->selectedAllergyFilter === 'NO_ALLERGY') {
                $query->where(function ($q) {
                    $q->whereNull('dietary_requirements')
                      ->orWhere('dietary_requirements', '[]')
                      ->whereNull('dietary_notes');
                });
            } else {
                $query->whereJsonContains('dietary_requirements', $this->selectedAllergyFilter);
            }
        }
    }

    public function render()
    {
        $query = DelegationMember::with(['delegation.country', 'skill', 'user']);
        $this->applyFilters($query);

        $members = $query->orderBy('first_name')->paginate($this->perPage);

        $totalMembers = DelegationMember::count();
        $membersWithAllergiesCount = DelegationMember::where(function ($q) {
            $q->whereNotNull('dietary_requirements')
              ->where('dietary_requirements', '!=', '[]')
              ->orWhere(function ($q2) {
                  $q2->whereNotNull('dietary_notes')->where('dietary_notes', '!=', '');
              });
        })->count();

        $dietaryOptions = self::getDietaryOptions();
        $allergyBreakdown = [];
        foreach (array_keys($dietaryOptions) as $key) {
            $allergyBreakdown[$key] = 0;
        }

        $allRaw = DelegationMember::select('dietary_requirements')->get();
        foreach ($allRaw as $m) {
            if (is_array($m->dietary_requirements)) {
                foreach ($m->dietary_requirements as $req) {
                    if (isset($allergyBreakdown[$req])) {
                        $allergyBreakdown[$req]++;
                    }
                }
            }
        }

        $countries = Country::orderBy('name_ar')->get();

        $printQuery = DelegationMember::with(['delegation.country', 'skill']);
        $this->applyFilters($printQuery);
        $printMembers = $printQuery->orderBy('first_name')->get();

        return view('livewire.admin.dietary.index', [
            'members'                   => $members,
            'printMembers'              => $printMembers,
            'totalMembers'              => $totalMembers,
            'membersWithAllergiesCount' => $membersWithAllergiesCount,
            'allergyBreakdown'          => $allergyBreakdown,
            'dietaryOptions'            => $dietaryOptions,
            'countries'                 => $countries,
        ]);
    }
}
