<?php

namespace App\Livewire\Admin;

use App\Enums\ParticipantStatus;
use App\Models\Country;
use App\Models\Edition;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('components.dashboard.app-shell')]
class AdminRegistrationIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterStatus  = '';
    public string $filterCountry = '';
    public string $filterSkill   = '';
    public string $filterWilaya  = '';
    public string $filterRole    = '';
    public string $filterEdition = '';

    // Detail Drawer
    public bool          $drawerOpen          = false;
    public ?Registration $selectedRegistration = null;

    // Status change modal
    public bool    $statusModalOpen   = false;
    public ?int    $statusTargetId    = null;
    public string  $newStatus         = '';
    public string  $rejectionReason   = '';

    // Delete confirm
    public bool $deleteConfirmOpen = false;
    public bool $rejectModalOpen   = false;
    public ?int $deleteTargetId    = null;

    protected $queryString = [
        'search'        => ['except' => ''],
        'filterStatus'  => ['except' => ''],
        'filterCountry' => ['except' => ''],
        'filterSkill'   => ['except' => ''],
        'filterWilaya'  => ['except' => ''],
        'filterRole'    => ['except' => ''],
        'filterEdition' => ['except' => ''],
    ];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterWilaya(): void  { $this->resetPage(); }
    public function updatingFilterRole(): void    { $this->resetPage(); }
    public function updatingFilterEdition(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterStatus', 'filterCountry', 'filterSkill', 'filterWilaya', 'filterRole', 'filterEdition']);
        $this->resetPage();
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedRegistration = Registration::with([
            'participant',
            'participant.user',
            'participant.wilaya',
            'participant.organization',
            'country',
            'skill',
            'edition',
            'documents',
        ])->findOrFail($id);
        $this->drawerOpen = true;
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->selectedRegistration = null;
    }

    /* ─── Status Change ─── */
    public function openStatusModal(int $id, string $status): void
    {
        $this->statusTargetId  = $id;
        $this->newStatus       = $status;
        $this->rejectionReason = '';
        $this->statusModalOpen = true;
    }

    public function applyStatus(): void
    {
        $registration = Registration::findOrFail($this->statusTargetId);
        $updateData   = ['status' => $this->newStatus, 'reviewed_at' => now()];

        if ($this->newStatus === ParticipantStatus::REJECTED->value) {
            $updateData['rejection_reason'] = $this->rejectionReason;
        }

        $registration->update($updateData);
        $this->statusModalOpen = false;
        $this->selectedRegistration = null;
        $this->drawerOpen = false;
        session()->flash('success', 'تم تحديث حالة التسجيل بنجاح.');
    }

    public function approveRegistration(int $id): void
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => ParticipantStatus::APPROVED->value, 'reviewed_at' => now()]);
        session()->flash('success', 'تم قبول طلب الترشح بنجاح.');
    }

    public function openRejectModal(int $id): void
    {
        $this->statusTargetId  = $id;
        $this->newStatus       = ParticipantStatus::REJECTED->value;
        $this->rejectionReason = '';
        $this->rejectModalOpen  = true;
    }

    public function rejectRegistration(): void
    {
        if ($this->statusTargetId) {
            $reg = Registration::findOrFail($this->statusTargetId);
            $reg->update([
                'status'           => ParticipantStatus::REJECTED->value,
                'rejection_reason' => $this->rejectionReason,
                'reviewed_at'      => now(),
            ]);
            $this->rejectModalOpen = false;
            session()->flash('warning', 'تم رفض طلب التسجيل.');
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteRegistration(): void
    {
        if ($this->deleteTargetId) {
            Registration::findOrFail($this->deleteTargetId)->delete();
        }
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        session()->flash('success', 'تم حذف التسجيل نهائياً.');
    }

    /* ─── Export Filtered Registrations to Excel (CSV) ─── */
    public function exportExcel()
    {
        $query = Registration::with(['participant', 'participant.user', 'participant.wilaya', 'participant.organization', 'country', 'skill'])
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $sq->where('registration_number', 'like', '%'.$this->search.'%')
                   ->orWhereHas('participant', function ($pq) {
                       $pq->where('first_name_ar', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name_ar', 'like', '%'.$this->search.'%')
                          ->orWhere('national_id', 'like', '%'.$this->search.'%')
                          ->orWhere('phone', 'like', '%'.$this->search.'%');
                   });
            }))
            ->when($this->filterStatus,  fn($q) => $q->where('status',     $this->filterStatus))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterWilaya,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->where('wilaya_id', $this->filterWilaya)))
            ->when($this->filterRole,    fn($q) => $q->whereHas('participant.user', fn($uq) => $uq->role($this->filterRole)))
            ->when($this->filterEdition, fn($q) => $q->where('edition_id', $this->filterEdition))
            ->orderByDesc('created_at');

        $registrations = $query->get();

        $csvData = [];
        $csvData[] = [
            'رقم التسجيل',
            'الاسم واللقب (عربي)',
            'الاسم واللقب (فرنسي)',
            'رقم التعريف الوطني (NIN)',
            'التخصص / المهارة',
            'الولاية',
            'الدولة',
            'المؤسسة التكوينية',
            'قياس البدلة',
            'قياس الحذاء',
            'القامة (سم)',
            'رقم الهاتف',
            'حالة الترشح',
            'تاريخ التقديم'
        ];

        foreach ($registrations as $r) {
            $p = $r->participant;
            $csvData[] = [
                $r->registration_number,
                ($p?->first_name_ar ?? '') . ' ' . ($p?->last_name_ar ?? ''),
                ($p?->first_name_fr ?? '') . ' ' . ($p?->last_name_fr ?? ''),
                $p?->national_id ?? '—',
                $r->skill?->getLocalized('name') ?? 'تخصص عام',
                $p?->wilaya?->name_ar ?? '—',
                $r->country?->name_ar ?? 'الجزائر',
                $p?->organization?->name_ar ?? '—',
                $r->suit_size ?? '—',
                $r->shoe_size ?? '—',
                $r->height_cm ? $r->height_cm . ' سم' : '—',
                $p?->phone ?? '—',
                $r->status instanceof ParticipantStatus ? $r->status->value : $r->status,
                $r->created_at ? $r->created_at->format('Y-m-d H:i') : '—',
            ];
        }

        $filename = 'WSAP_Registrations_Export_' . date('Y_m_d_His') . '.csv';

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

    public function render()
    {
        $query = Registration::with([
            'participant',
            'participant.user',
            'participant.wilaya',
            'participant.organization',
            'country',
            'skill',
            'edition'
        ])
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $sq->where('registration_number', 'like', '%'.$this->search.'%')
                   ->orWhereHas('participant', function ($pq) {
                       $pq->where('first_name_ar', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name_ar', 'like', '%'.$this->search.'%')
                          ->orWhere('first_name_fr', 'like', '%'.$this->search.'%')
                          ->orWhere('last_name_fr', 'like', '%'.$this->search.'%')
                          ->orWhere('national_id', 'like', '%'.$this->search.'%')
                          ->orWhere('phone', 'like', '%'.$this->search.'%');
                   });
            }))
            ->when($this->filterStatus,  fn($q) => $q->where('status',     $this->filterStatus))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterWilaya,  fn($q) => $q->whereHas('participant', fn($pq) => $pq->where('wilaya_id', $this->filterWilaya)))
            ->when($this->filterRole,    fn($q) => $q->whereHas('participant.user', fn($uq) => $uq->role($this->filterRole)))
            ->when($this->filterEdition, fn($q) => $q->where('edition_id', $this->filterEdition))
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at');

        $statuses = ParticipantStatus::cases();

        return view('livewire.admin.registrations.index', [
            'registrations'        => $query->paginate(15),
            'statuses'             => $statuses,
            'wilayas'              => Wilaya::orderBy('code')->get(),
            'countries'            => Country::orderBy('name_ar')->get(),
            'skills'               => Skill::orderBy('name_ar')->get(),
            'roles'                => Role::pluck('name'),
            'editions'             => Edition::orderByDesc('year')->get(),
            'totalCount'           => Registration::count(),
            'approvedCount'        => Registration::where('status', 'APPROVED')->count(),
            'pendingCount'         => Registration::whereIn('status', ['PENDING', 'SUBMITTED', 'UNDER_REVIEW'])->count(),
            'rejectedCount'        => Registration::where('status', 'REJECTED')->count(),
            'selectedRegistration' => $this->selectedRegistration,
            'search'               => $this->search,
            'filterStatus'         => $this->filterStatus,
            'filterCountry'        => $this->filterCountry,
            'filterSkill'          => $this->filterSkill,
            'filterWilaya'         => $this->filterWilaya,
            'filterRole'           => $this->filterRole,
            'filterEdition'        => $this->filterEdition,
            'drawerOpen'           => $this->drawerOpen,
            'statusModalOpen'      => $this->statusModalOpen,
            'rejectModalOpen'      => $this->rejectModalOpen,
            'deleteConfirmOpen'    => $this->deleteConfirmOpen,
        ]);
    }
}
