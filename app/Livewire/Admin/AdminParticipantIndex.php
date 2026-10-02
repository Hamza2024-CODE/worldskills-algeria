<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminParticipantIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterCountry = '';
    public string $filterWilaya  = '';
    public string $filterSkill   = '';
    public string $filterGender  = '';

    public bool   $drawerOpen    = false;
    public ?Registration $selected = null;

    // Delete modal
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId    = null;

    protected $queryString = [
        'search'        => ['except' => ''],
        'filterCountry' => ['except' => ''],
        'filterWilaya'  => ['except' => ''],
        'filterSkill'   => ['except' => ''],
        'filterGender'  => ['except' => ''],
    ];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterWilaya(): void  { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterGender(): void  { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterCountry', 'filterWilaya', 'filterSkill', 'filterGender']);
        $this->resetPage();
    }

    public function openDrawer(int $id): void
    {
        $this->selected = Registration::with([
            'participant',
            'participant.user',
            'participant.wilaya',
            'participant.organization',
            'skill',
            'country',
            'documents'
        ])->find($id);

        $this->drawerOpen = true;
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->selected   = null;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteParticipant(): void
    {
        if ($this->deleteTargetId) {
            $reg = Registration::find($this->deleteTargetId);
            if ($reg) {
                if ($reg->participant_id) {
                    ParticipantProfile::where('id', $reg->participant_id)->delete();
                }
                $reg->delete();
            }
        }
        $this->deleteConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->selected          = null;
        $this->resetPage();
        session()->flash('success', 'تم حذف المشارك نهائياً من قاعدة البيانات.');
    }

        /* ─── Export Printable PDF List (قائمة المتأهلين للطباعة وحفظ PDF) ─── */
    public function exportPdf()
    {
        $query = Registration::with(['participant', 'participant.wilaya', 'participant.organization', 'country', 'skill'])
            ->whereIn('status', ['APPROVED', 'QUALIFIED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL', 'COMPLETED'])
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('registration_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('participant', function ($pq) {
                        $pq->where('first_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('first_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('national_id', 'like', '%'.$this->search.'%')
                           ->orWhere('phone', 'like', '%'.$this->search.'%');
                    });
            }))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterWilaya,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->where('wilaya_id', $this->filterWilaya)))
            ->when($this->filterGender,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->whereIn('gender', $this->filterGender === 'MALE' ? ['MALE', 'male', 'ذكر'] : ['FEMALE', 'female', 'أنثى'])));

        // Sort by Wilaya Code, then Organization Name, then Skill Code
        $registrations = $query->get()->sortBy(function($r) {
            $wilayaCode = sprintf('%02d', (int)($r->participant?->wilaya?->code ?? 99));
            $orgName = $r->participant?->organization?->name_ar ?? 'zzz';
            $skillCode = $r->skill?->code ?? 'zzz';
            return $wilayaCode . '_' . $orgName . '_' . $skillCode;
        })->values();

        $wilayaName  = $this->filterWilaya ? Wilaya::find($this->filterWilaya)?->name_ar : 'كافة الولايات (58 ولاية)';
        $countryName = $this->filterCountry ? Country::find($this->filterCountry)?->name_ar : 'الجمهورية الجزائرية الديمقراطية الشعبية';
        $skillName   = $this->filterSkill ? Skill::find($this->filterSkill)?->name_ar : 'كافة التخصصات والمهارات';

        $html = view('pdf.registrations-list', [
            'registrations'    => $registrations,
            'wilayaName'       => $wilayaName,
            'countryName'      => $countryName,
            'skillName'        => $skillName,
            'organizationName' => 'كافة المؤسسات التكوينية',
            'generatedAt'      => now()->format('Y-m-d H:i'),
        ])->render();

        $filename = 'WorldSkills_DZ_Finalistes_Nationaux_' . date('Y_m_d_His') . '.html';

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    /* ─── Export Filtered Approved Participants to Official Excel (.xls) ─── */
    public function exportExcel()
    {
        $query = Registration::with(['participant', 'participant.wilaya', 'participant.organization', 'country', 'skill'])
            ->whereIn('status', ['APPROVED', 'QUALIFIED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL', 'COMPLETED'])
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('registration_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('participant', function ($pq) {
                        $pq->where('first_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('first_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('national_id', 'like', '%'.$this->search.'%')
                           ->orWhere('phone', 'like', '%'.$this->search.'%');
                    });
            }))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterWilaya,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->where('wilaya_id', $this->filterWilaya)))
            ->when($this->filterGender,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->whereIn('gender', $this->filterGender === 'MALE' ? ['MALE', 'male', 'ذكر'] : ['FEMALE', 'female', 'أنثى'])));

        // Sort by Wilaya Code, then Organization Name, then Skill Code
        $registrations = $query->get()->sortBy(function($r) {
            $wilayaCode = sprintf('%02d', (int)($r->participant?->wilaya?->code ?? 99));
            $orgName = $r->participant?->organization?->name_ar ?? 'zzz';
            $skillCode = $r->skill?->code ?? 'zzz';
            return $wilayaCode . '_' . $orgName . '_' . $skillCode;
        })->values();

        $wilayaName = $this->filterWilaya ? Wilaya::find($this->filterWilaya)?->name_ar : 'كافة الولايات (58 ولاية)';
        $skillName  = $this->filterSkill ? Skill::find($this->filterSkill)?->name_ar : 'كافة التخصصات والمهارات';

        $html = view('exports.national-finalists-excel', [
            'registrations' => $registrations,
            'wilayaName'    => $wilayaName,
            'skillName'     => $skillName,
            'generatedAt'   => now()->format('Y-m-d H:i'),
        ])->render();

        $filename = 'WorldSkills_DZ_Finalistes_Nationaux_' . date('Y_m_d') . '.xls';

        return response()->streamDownload(function () use ($html) {
            echo chr(239) . chr(187) . chr(191); // UTF-8 BOM
            echo $html;
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }


    public function render()
    {
        // STRICT RULE: Only Approved Participants are displayed on this page
        $query = Registration::with(['participant', 'participant.user', 'participant.wilaya', 'participant.organization', 'country', 'skill'])
            ->whereIn('status', ['APPROVED', 'QUALIFIED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL', 'COMPLETED'])
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('registration_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('participant', function ($pq) {
                        $pq->where('first_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_ar', 'like', '%'.$this->search.'%')
                           ->orWhere('first_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('last_name_fr', 'like', '%'.$this->search.'%')
                           ->orWhere('national_id', 'like', '%'.$this->search.'%')
                           ->orWhere('phone', 'like', '%'.$this->search.'%');
                    });
            }))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterWilaya,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->where('wilaya_id', $this->filterWilaya)))
            ->when($this->filterGender,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->whereIn('gender', $this->filterGender === 'MALE' ? ['MALE', 'male', 'ذكر'] : ['FEMALE', 'female', 'أنثى'])))
            ->orderByDesc('id');

        $totalApproved = Registration::whereIn('status', ['APPROVED', 'QUALIFIED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL', 'COMPLETED'])->count();

        // Calculate male and female counts SPECIFICALLY for approved participants
        $femaleApproved = Registration::whereIn('status', ['APPROVED', 'QUALIFIED', 'QUALIFIED_REGIONAL', 'QUALIFIED_NATIONAL', 'COMPLETED'])
            ->whereHas('participant', fn($pq) => $pq->whereIn('gender', ['FEMALE', 'female', 'أنثى']))
            ->count();

        $maleApproved = max(0, $totalApproved - $femaleApproved);

        return view('livewire.admin.participants.index', [
            'registrations'     => $query->paginate(15),
            'wilayas'           => Wilaya::orderBy('code')->get(),
            'countries'         => Country::orderBy('name_ar')->get(),
            'skills'            => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'totalApproved'     => $totalApproved,
            'maleApproved'      => $maleApproved,
            'femaleApproved'    => $femaleApproved,
            'totalSkills'       => Skill::count(),
            'search'            => $this->search,
            'filterCountry'     => $this->filterCountry,
            'filterWilaya'      => $this->filterWilaya,
            'filterSkill'       => $this->filterSkill,
            'filterGender'      => $this->filterGender,
            'drawerOpen'        => $this->drawerOpen,
            'selected'          => $this->selected,
            'deleteConfirmOpen' => $this->deleteConfirmOpen,
        ]);
    }
}
