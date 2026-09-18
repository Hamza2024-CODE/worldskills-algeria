<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\CompetitionAssignment;
use App\Models\Organization;
use App\Models\Skill;
use App\Models\User;
use App\Models\Wilaya;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminJudgeIndex extends Component
{
    use WithPagination;

    // Filters
    public string $search = '';
    public string $filterCountry = '';
    public string $filterWilaya = '';
    public string $filterOrganization = '';
    public string $filterSkill = '';
    public string $filterStatus = ''; // 'active', 'inactive'

    // Form Modals
    public bool $createFormOpen = false;
    public bool $isEditing = false;
    public ?int $editingUserId = null;

    // Form Fields
    #[Validate('required|min:3')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    public string $password = '';
    public ?int $country_id = null;
    public ?int $wilaya_id = null;
    public ?int $organization_id = null;
    public ?int $skill_id = null;
    public string $assignment_type = 'CHIEF_JUDGE';
    public bool $is_active = true;

    // Drawer & Details
    public bool $drawerOpen = false;
    public ?User $selectedJudge = null;

    // Delete Modal
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetUserId = null;

    protected $queryString = ['search', 'filterCountry', 'filterWilaya', 'filterOrganization', 'filterSkill', 'filterStatus'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterWilaya(): void { $this->resetPage(); }
    public function updatingFilterOrganization(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->createFormOpen = true;
    }

    public function openEdit(int $userId): void
    {
        $user = User::with(['competitionAssignments' => fn($q) => $q->where('is_active', true)])->findOrFail($userId);
        $activeAssignment = $user->competitionAssignments->first();

        $this->editingUserId     = $user->id;
        $this->name              = $user->name;
        $this->email             = $user->email;
        $this->password          = '';
        $this->country_id        = $user->country_id;
        $this->wilaya_id         = $user->wilaya_id;
        $this->organization_id   = $user->organization_id;
        $this->skill_id          = $activeAssignment?->skill_id;
        $this->assignment_type   = $activeAssignment?->assignment_type ?? 'CHIEF_JUDGE';
        $this->is_active         = (bool) $user->is_active;

        $this->isEditing         = true;
        $this->createFormOpen    = true;
    }

    public function saveJudge(): void
    {
        if ($this->isEditing) {
            $this->validate([
                'name'  => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $this->editingUserId,
            ]);

            $user = User::findOrFail($this->editingUserId);
            $userData = [
                'name'            => trim($this->name),
                'email'           => trim($this->email),
                'country_id'      => $this->country_id ?: null,
                'wilaya_id'       => $this->wilaya_id ?: null,
                'organization_id' => $this->organization_id ?: null,
                'is_active'       => $this->is_active,
            ];

            if (!empty($this->password)) {
                $userData['password'] = Hash::make($this->password);
            }

            $user->update($userData);

            // Update assignment if skill selected
            if ($this->skill_id) {
                // Deactivate old active assignments
                CompetitionAssignment::where('user_id', $user->id)->update(['is_active' => false]);

                CompetitionAssignment::create([
                    'user_id'         => $user->id,
                    'skill_id'        => $this->skill_id,
                    'assignment_type' => $this->assignment_type,
                    'assigned_by'     => auth()->id(),
                    'assigned_at'     => now(),
                    'is_active'       => true,
                ]);
            }

            $msg = 'تم تحديث بيانات المحكم الخبير وتعييناته بنجاح';
        } else {
            $this->validate([
                'name'  => 'required|min:3',
                'email' => 'required|email|unique:users,email',
            ]);

            $plainPassword = $this->password ?: 'Judge2026!';

            $user = User::create([
                'name'            => trim($this->name),
                'email'           => trim($this->email),
                'password'        => Hash::make($plainPassword),
                'country_id'      => $this->country_id ?: null,
                'wilaya_id'       => $this->wilaya_id ?: null,
                'organization_id' => $this->organization_id ?: null,
                'is_active'       => $this->is_active,
                'locale'          => 'ar',
            ]);

            // Assign JUDGE spatie role
            $user->syncRoles([RoleEnum::JUDGE->value]);

            if ($this->skill_id) {
                CompetitionAssignment::create([
                    'user_id'         => $user->id,
                    'skill_id'        => $this->skill_id,
                    'assignment_type' => $this->assignment_type,
                    'assigned_by'     => auth()->id(),
                    'assigned_at'     => now(),
                    'is_active'       => true,
                ]);
            }

            $msg = 'تم إضافة المحكم الخبير الجديد وتفعيل حساب الدخول بنجاح';
        }

        $this->createFormOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        $this->dispatch('notify', ['type' => 'info', 'msg' => 'تم تغيير حالة تفعيل المحكم']);
    }

    public function openDrawer(int $userId): void
    {
        $this->selectedJudge = User::with([
            'country',
            'wilaya',
            'organization',
            'competitionAssignments.skill',
            'competitionAssignments.assigner',
        ])->findOrFail($userId);

        $this->drawerOpen = true;
    }

    public function confirmDelete(int $userId): void
    {
        $this->deleteTargetUserId = $userId;
        $this->deleteConfirmOpen  = true;
    }

    public function deleteJudge(): void
    {
        $user = User::findOrFail($this->deleteTargetUserId);
        
        // Deactivate assignments
        CompetitionAssignment::where('user_id', $user->id)->delete();
        $user->delete();

        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف المحكم وإلغاء حسابه بنجاح']);
    }

    private function resetForm(): void
    {
        $this->editingUserId = null;
        $this->name = $this->email = $this->password = '';
        $this->country_id = $this->wilaya_id = $this->organization_id = $this->skill_id = null;
        $this->assignment_type = 'CHIEF_JUDGE';
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $judges = $this->getFilteredQuery()->get();

        $csvData = [];
        $csvData[] = ['#ID', 'الاسم واللقب', 'البريد الإلكتروني', 'الدولة', 'الولاية', 'المركز / المؤسسة', 'التخصص المسند', 'الصفة التحكيمية', 'حالة الحساب'];

        foreach ($judges as $j) {
            $assignment = $j->competitionAssignments->firstWhere('is_active', true);
            $csvData[] = [
                $j->id,
                $j->name,
                $j->email,
                $j->country?->name_ar ?? 'الجزائر',
                $j->wilaya?->name_ar ?? '—',
                $j->organization?->name_ar ?? '—',
                $assignment?->skill?->name_ar ?? 'غير مسند',
                $assignment ? ($assignment->assignment_type === 'CHIEF_JUDGE' ? 'رئيس لجنة التحكيم' : 'خبير محكم معتمد') : 'بدون صفة',
                $j->is_active ? 'نشط ومفعل' : 'معطل',
            ];
        }

        $filename = 'WSAP_Judges_Experts_' . date('Y_m_d_His') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getFilteredQuery()
    {
        return User::role(RoleEnum::JUDGE->value)
            ->with(['country', 'wilaya', 'organization', 'competitionAssignments' => fn($q) => $q->where('is_active', true)->with('skill')])
            ->when($this->search !== '', fn($q) => $q->where(fn($sub) =>
                $sub->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%')
            ))
            ->when($this->filterCountry !== '', fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterWilaya !== '', fn($q) => $q->where('wilaya_id', $this->filterWilaya))
            ->when($this->filterOrganization !== '', fn($q) => $q->where('organization_id', $this->filterOrganization))
            ->when($this->filterSkill !== '', fn($q) => $q->whereHas('competitionAssignments', fn($sub) => $sub->where('skill_id', $this->filterSkill)->where('is_active', true)))
            ->when($this->filterStatus === 'active', fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false));
    }

    public function render()
    {
        $query = $this->getFilteredQuery();

        return view('livewire.admin.judges.index', [
            'judges'              => $query->orderBy('name')->paginate(15),
            'countries'           => Country::orderBy('name_ar')->get(),
            'wilayas'             => Wilaya::orderBy('code')->get(),
            'organizations'       => Organization::orderBy('name_ar')->get(),
            'skills'              => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'totalJudges'         => User::role(RoleEnum::JUDGE->value)->count(),
            'activeAssignments'   => CompetitionAssignment::where('is_active', true)->count(),
            'activeJudgesCount'   => User::role(RoleEnum::JUDGE->value)->where('is_active', true)->count(),
        ]);
    }
}
