<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\Certificate;
use App\Models\Country;
use App\Models\Organization;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Models\Wilaya;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminCertificateIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterRole    = '';
    public string $filterStatus  = '';
    public string $filterAward   = '';
    public string $filterSkill   = '';
    public string $filterCountry = '';
    public string $filterWilaya  = '';
    public string $filterCenter  = ''; // Organization / Center Filter

    // Checkbox multi-selection for bulk actions
    public array  $selectedRegistrations = [];
    public bool   $selectAll             = false;

    // Issue modal
    public bool   $formOpen         = false;
    public int    $registration_id  = 0;
    public string $certificate_type = 'PARTICIPATION';

    protected $queryString = [
        'search', 'filterRole', 'filterStatus', 'filterAward', 'filterSkill', 'filterCountry', 'filterWilaya', 'filterCenter'
    ];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterRole(): void    { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }
    public function updatingFilterAward(): void   { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterWilaya(): void  { $this->resetPage(); }
    public function updatingFilterCenter(): void  { $this->resetPage(); }

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedRegistrations = $this->getFilteredRegistrationsQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedRegistrations = [];
        }
    }

    public function clearSelection(): void
    {
        $this->selectedRegistrations = [];
        $this->selectAll             = false;
    }

    public function openCreate(): void
    {
        $this->reset(['registration_id', 'certificate_type']);
        $this->certificate_type = 'PARTICIPATION';
        $this->formOpen         = true;
    }

    public function issue(): void
    {
        $this->validate([
            'registration_id'  => 'required|integer|min:1',
            'certificate_type' => 'required|string',
        ]);

        $reg = Registration::find($this->registration_id);
        if ($reg) {
            (new CertificateService())->issue(
                $reg->user?->id ?? 1,
                $this->certificate_type,
                $reg->id,
                $reg->skill_id
            );
            $this->formOpen = false;
            session()->flash('success', 'تم استخراج وتوثيق الشهادة الرسمية بنجاح.');
        }
    }

    /* ─── Export Certificates to CSV ─── */
    public function exportExcel()
    {
        $regs = $this->getFilteredRegistrationsQuery()->latest()->get();

        $csvData = [];
        $csvData[] = [
            'ID',
            'رقم التسجيل',
            'الاسم بالعربية',
            'الاسم باللاتينية',
            'الدور والصفة المعتمدة',
            'حالة الاعتماد والقبول',
            'التخصص المهني',
            'المركز / المؤسسة',
            'الولاية',
            'الدولة / الوفد',
            'نقاط التقييم CIS',
            'الرتبة والنتيجة',
            'نوع الشهادة المستحقة'
        ];

        foreach ($regs as $reg) {
            $num       = $reg->registration_number;
            $nameAr    = $reg->participant?->first_name_ar ? ($reg->participant->first_name_ar . ' ' . $reg->participant->last_name_ar) : $reg->user?->name;
            $nameLatin = $reg->participant?->first_name_fr ? ($reg->participant->first_name_fr . ' ' . $reg->participant->last_name_fr) : $reg->user?->email;
            $statusStr = is_object($reg->status) ? ($reg->status->value ?? 'APPROVED') : ($reg->status ?? 'APPROVED');
            $userRole  = $reg->user?->roles->first()?->name ?? 'PARTICIPANT';

            $score     = $reg->result?->final_score ? number_format($reg->result->final_score, 2) : '—';
            $rank      = $reg->result?->rank ? ('المركز ' . $reg->result->rank) : '—';
            $award     = $reg->result?->award ?? '—';

            // Auto suggested cert type
            $suggestedCert = match(true) {
                $award === 'GOLD' || $reg->result?->rank == 1            => 'شهادة الميدالية الذهبية (WINNER_GOLD)',
                $award === 'SILVER' || $reg->result?->rank == 2          => 'شهادة الميدالية الفضية (WINNER_SILVER)',
                $award === 'BRONZE' || $reg->result?->rank == 3          => 'شهادة الميدالية البرونزية (WINNER_BRONZE)',
                ($reg->result?->final_score ?? 0) >= 700                  => 'شهادة التميز (MEDALLION_EXCELLENCE)',
                $userRole === RoleEnum::JUDGE->value || $userRole === RoleEnum::EXPERT->value => 'شهادة حكم خبير (EXPERT_JUDGE)',
                $userRole === RoleEnum::COUNTRY_ADMIN->value             => 'شهادة رئيس وفد (DELEGATION_HEAD)',
                $userRole === RoleEnum::SPONSOR->value                   => 'شهادة متعامل اقتصادي (ECONOMIC_PARTNER)',
                $userRole === RoleEnum::MEDIA_MANAGER->value             => 'شهادة صحفي إعلامي (MEDIA)',
                $userRole === RoleEnum::ORGANIZATION_ADMIN->value || $userRole === RoleEnum::SUPER_ADMIN->value => 'شهادة منظم معتمد (ORGANIZER)',
                default                                                  => 'شهادة مشاركة وتأهل (PARTICIPATION)',
            };

            $csvData[] = [
                $reg->id,
                $num,
                $nameAr,
                $nameLatin,
                $userRole,
                $statusStr,
                $reg->skill?->name_ar ?? 'تخصص مهني',
                $reg->organization?->name_ar ?? '—',
                $reg->wilaya?->name_ar ?? '—',
                $reg->country?->name_ar ?? 'الجزائر',
                $score,
                $rank,
                $suggestedCert,
            ];
        }

        $filename = 'WSAP_Official_Certificates_' . date('Y_m_d_His') . '.csv';

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

    private function getFilteredRegistrationsQuery()
    {
        return Registration::with([
            'participant.user.roles',
            'country',
            'skill',
            'organization',
            'wilaya',
            'result'
        ])
        // STRICT RULE: Strictly EXCLUDE REJECTED records (show only approved/active candidates by default)
        ->whereNotIn('status', ['REJECTED', 'REJECTED_BY_ADMIN', 'REJECTED_BY_SUPER_ADMIN'])
        // Filter by Status if specifically selected
        ->when($this->filterStatus, function ($q) {
            $q->where('status', $this->filterStatus);
        })
        // Search
        ->when($this->search, function ($q) {
            $s = '%' . $this->search . '%';
            $q->where(function ($sub) use ($s) {
                $sub->where('registration_number', 'like', $s)
                    ->orWhere('verification_token', 'like', $s)
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', $s)->orWhere('email', 'like', $s))
                    ->orWhereHas('participant', fn($p) =>
                        $p->where('first_name_ar', 'like', $s)
                          ->orWhere('last_name_ar', 'like', $s)
                          ->orWhere('first_name_fr', 'like', $s)
                          ->orWhere('last_name_fr', 'like', $s)
                          ->orWhere('national_id', 'like', $s)
                          ->orWhere('passport_number', 'like', $s)
                    );
            });
        })
        // Filter by Expanded Role
        ->when($this->filterRole, function ($q) {
            $roleMap = [
                'COMPETITOR'       => [RoleEnum::PARTICIPANT->value],
                'EXPERT_JUDGE'     => [RoleEnum::JUDGE->value, RoleEnum::EXPERT->value],
                'DELEGATION_HEAD'  => [RoleEnum::COUNTRY_ADMIN->value],
                'SUPERVISOR'       => [RoleEnum::REGIONAL_ADMIN->value, RoleEnum::WILAYA_ADMIN->value],
                'ECONOMIC_PARTNER' => [RoleEnum::SPONSOR->value],
                'MEDIA'            => [RoleEnum::MEDIA_MANAGER->value],
                'VIP'              => [RoleEnum::EXECUTIVE_VIEWER->value],
                'ORGANIZER'        => [RoleEnum::ORGANIZATION_ADMIN->value, RoleEnum::SUPER_ADMIN->value],
            ];
            if (isset($roleMap[$this->filterRole])) {
                $q->whereHas('user.roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]));
            }
        })
        // Filter by Award / CIS Score Rank
        ->when($this->filterAward, function ($q) {
            if ($this->filterAward === 'WINNER_GOLD') {
                $q->whereHas('result', fn($r) => $r->where('award', 'GOLD')->orWhere('rank', 1));
            } elseif ($this->filterAward === 'WINNER_SILVER') {
                $q->whereHas('result', fn($r) => $r->where('award', 'SILVER')->orWhere('rank', 2));
            } elseif ($this->filterAward === 'WINNER_BRONZE') {
                $q->whereHas('result', fn($r) => $r->where('award', 'BRONZE')->orWhere('rank', 3));
            } elseif ($this->filterAward === 'MEDALLION_EXCELLENCE') {
                $q->whereHas('result', fn($r) => $r->where('final_score', '>=', 700));
            } elseif ($this->filterAward === 'WINNERS_ONLY') {
                $q->whereHas('result', fn($r) => $r->whereIn('rank', [1, 2, 3])->orWhereIn('award', ['GOLD', 'SILVER', 'BRONZE']));
            } elseif ($this->filterAward === 'PARTICIPATION') {
                $q->whereDoesntHave('result')
                  ->orWhereHas('result', fn($r) => $r->whereNull('award')->whereNotIn('rank', [1, 2, 3]));
            }
        })
        // Filter by Skill
        ->when($this->filterSkill, function ($q) {
            $q->where('skill_id', $this->filterSkill);
        })
        // Filter by Country
        ->when($this->filterCountry, function ($q) {
            $q->where('country_id', $this->filterCountry);
        })
        // Filter by Wilaya
        ->when($this->filterWilaya, function ($q) {
            $q->whereHas('participant', fn($p) => $p->where('wilaya_id', $this->filterWilaya));
        })
        // Filter by Center / Organization
        ->when($this->filterCenter, function ($q) {
            $q->whereHas('participant', fn($p) => $p->where('organization_id', $this->filterCenter));
        });
    }

    public function render()
    {
        $registrations = $this->getFilteredRegistrationsQuery()->orderByDesc('created_at')->paginate(12);

        $baseQuery = Registration::whereNotIn('status', ['REJECTED', 'REJECTED_BY_ADMIN', 'REJECTED_BY_SUPER_ADMIN']);

        return view('livewire.admin.certificates.index', [
            'registrations'  => $registrations,
            'allApprovedRegs'=> (clone $baseQuery)->where('status', 'APPROVED')->take(100)->get(),
            'countries'      => Country::orderBy('name_ar')->get(),
            'skills'         => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'wilayas'        => Wilaya::orderBy('code')->get(),
            'organizations'  => Organization::orderBy('name_ar')->get(),
            'totalApproved'  => (clone $baseQuery)->where('status', 'APPROVED')->count(),
            'winnersCount'   => (clone $baseQuery)->whereHas('result', fn($r) => $r->whereIn('rank', [1, 2, 3])->orWhereIn('award', ['GOLD', 'SILVER', 'BRONZE']))->count(),
            'goldCount'      => (clone $baseQuery)->whereHas('result', fn($r) => $r->where('award', 'GOLD')->orWhere('rank', 1))->count(),
            'silverCount'    => (clone $baseQuery)->whereHas('result', fn($r) => $r->where('award', 'SILVER')->orWhere('rank', 2))->count(),
            'bronzeCount'    => (clone $baseQuery)->whereHas('result', fn($r) => $r->where('award', 'BRONZE')->orWhere('rank', 3))->count(),
            'excellenceCount'=> (clone $baseQuery)->whereHas('result', fn($r) => $r->where('final_score', '>=', 700))->count(),
        ]);
    }
}
