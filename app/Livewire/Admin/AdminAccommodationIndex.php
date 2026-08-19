<?php

namespace App\Livewire\Admin;

use App\Models\Accommodation;
use App\Models\AccommodationRoom;
use App\Models\Country;
use App\Models\ParticipantProfile;
use App\Models\RoomAllocation;
use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminAccommodationIndex extends Component
{
    use WithPagination;

    public string $search              = '';
    public string $filterStatus        = '';
    public string $filterCountry       = '';
    public string $filterSkill         = '';
    public string $filterAccommodation = '';
    public string $filterArrivalStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:2')] public string $name_ar        = '';
    #[Validate('required|min:2')] public string $name_fr        = '';
    #[Validate('nullable')]       public string $address        = '';
    #[Validate('nullable')]       public string $contact_phone  = '';
    #[Validate('nullable|integer|min:1')] public ?int $total_capacity = null;
    #[Validate('nullable')]       public string $status         = 'AVAILABLE';

    // Rooms sub-form
    public bool   $roomsFormOpen        = false;
    public ?int   $roomsAccommodationId = null;
    public string $roomsAccommodationName = '';
    public array  $roomsList            = [];

    // New room fields
    public string $new_room_number = '';
    public ?int   $new_capacity    = null;
    public string $new_gender      = '';

    // Drawer & Delete
    public bool            $drawerOpen           = false;
    public ?Accommodation  $selectedAccommodation = null;
    public bool            $deleteConfirmOpen    = false;
    public ?int            $deleteTargetId       = null;

    // Allocation Modal Filters & Selections
    public bool $allocateModalOpen        = false;
    public ?int $allocateCountryId        = null;
    public ?int $allocateWilayaId         = null;
    public ?int $allocateAccommodationId  = null;
    public ?int $selectedParticipantId    = null;
    public ?int $selectedRoomId           = null;

    protected $queryString = ['search', 'filterStatus', 'filterCountry', 'filterSkill', 'filterAccommodation', 'filterArrivalStatus'];

    public function updatingSearch(): void              { $this->resetPage(); }
    public function updatingFilterStatus(): void        { $this->resetPage(); }
    public function updatingFilterCountry(): void       { $this->resetPage(); }
    public function updatingFilterSkill(): void         { $this->resetPage(); }
    public function updatingFilterAccommodation(): void { $this->resetPage(); }
    public function updatingFilterArrivalStatus(): void { $this->resetPage(); }

    /* ─── Form Handlers ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $a = Accommodation::findOrFail($id);
        $this->editingId       = $id;
        $this->name_ar         = $a->name_ar ?? '';
        $this->name_fr         = $a->name_fr ?? '';
        $this->address         = $a->address ?? '';
        $this->contact_phone   = $a->contact_phone ?? '';
        $this->total_capacity  = $a->total_capacity;
        $this->status          = $a->status ?? 'AVAILABLE';
        $this->isEditing       = true;
        $this->formOpen        = true;
    }

    public function save(): void
    {
        $this->validate(['name_ar' => 'required|min:2', 'name_fr' => 'required|min:2']);
        $data = [
            'name_ar'        => $this->name_ar,
            'name_fr'        => $this->name_fr,
            'address'        => $this->address,
            'contact_phone'  => $this->contact_phone,
            'total_capacity' => $this->total_capacity,
            'status'         => $this->status,
        ];
        $this->isEditing
            ? Accommodation::findOrFail($this->editingId)->update($data)
            : Accommodation::create($data);

        $this->formOpen = false;
        $this->resetForm();
        session()->flash('success', 'تم حفظ السكن بنجاح.');
    }

    /* ─── Rooms Management ─── */
    public function openRooms(int $id): void
    {
        $accommodation = Accommodation::with('rooms')->findOrFail($id);
        $this->roomsAccommodationId   = $id;
        $this->roomsAccommodationName = $accommodation->name_ar;
        $this->roomsList              = $accommodation->rooms->toArray();
        $this->roomsFormOpen          = true;
    }

    public function addRoom(): void
    {
        if (!$this->new_room_number) return;
        AccommodationRoom::create([
            'accommodation_id' => $this->roomsAccommodationId,
            'room_number'      => $this->new_room_number,
            'capacity'         => $this->new_capacity ?? 1,
            'gender'           => $this->new_gender ?: null,
            'status'           => 'AVAILABLE',
        ]);
        $this->new_room_number = '';
        $this->new_capacity    = null;
        $this->new_gender      = '';
        $accommodation = Accommodation::with('rooms')->findOrFail($this->roomsAccommodationId);
        $this->roomsList = $accommodation->rooms->toArray();
        session()->flash('success', 'تمت إضافة الغرفة بنجاح.');
    }

    public function deleteRoom(int $roomId): void
    {
        AccommodationRoom::findOrFail($roomId)->delete();
        $accommodation = Accommodation::with('rooms')->findOrFail($this->roomsAccommodationId);
        $this->roomsList = $accommodation->rooms->toArray();
    }

    /* ─── Drawer & Delete Handlers ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedAccommodation = Accommodation::withCount('rooms')->with('rooms')->find($id);
        $this->drawerOpen            = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteAccommodation(): void
    {
        if ($this->deleteTargetId) {
            Accommodation::findOrFail($this->deleteTargetId)->delete();
        }
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        session()->flash('success', 'تم حذف السكن بنجاح.');
    }

    /* ─── Allocation Handlers ─── */
    public function openAllocateModal(): void
    {
        $this->reset(['allocateCountryId', 'allocateWilayaId', 'allocateAccommodationId', 'selectedParticipantId', 'selectedRoomId']);
        $this->allocateModalOpen = true;
    }

    public function saveAllocation(): void
    {
        $this->validate([
            'selectedParticipantId' => 'required|integer|min:1',
            'selectedRoomId'        => 'required|integer|min:1',
        ]);

        RoomAllocation::updateOrCreate(
            ['participant_profile_id' => $this->selectedParticipantId],
            [
                'room_id'     => $this->selectedRoomId,
                'user_id'     => \Illuminate\Support\Facades\Auth::id(),
                'status'      => 'ACTIVE',
                'check_in_at' => now(),
            ]
        );

        $this->allocateModalOpen = false;
        session()->flash('success', 'تم ربط وتسكين المشارك في الغرفة المحددة بنجاح.');
    }

    public function deleteAllocation(int $allocationId): void
    {
        RoomAllocation::findOrFail($allocationId)->delete();
        session()->flash('success', 'تم إلغاء تسكين المشارك بنجاح.');
    }

    /* ─── Platform-Wide Excel Export ─── */
    public function exportExcel()
    {
        $allocations = RoomAllocation::with([
            'participantProfile.user',
            'participantProfile.registrations.skill',
            'participantProfile.registrations.country',
            'room.accommodation'
        ])->get();

        $csvData = [];
        $csvData[] = [
            'ID الرقم',
            'اسم المشارك / عضو الوفد',
            'البريد الإلكتروني',
            'الدولة / الوفد',
            'التخصص المهني',
            'مقر الإقامة / الفندق',
            'رقم الغرفة',
            'حالة الوصول والتسكين',
            'تاريخ ووقت التسكين'
        ];

        foreach ($allocations as $alloc) {
            $profile = $alloc->participantProfile;
            $reg = $profile?->registrations?->first();
            $country = $reg?->country?->name_ar ?? '—';
            $skill = $reg?->skill?->name_ar ?? '—';
            $accommodation = $alloc->room?->accommodation?->name_ar ?? '—';
            $room = $alloc->room?->room_number ?? '—';

            $csvData[] = [
                $alloc->id,
                ($profile?->first_name_ar . ' ' . $profile?->last_name_ar) ?: ($profile?->user?->name ?? '—'),
                $profile?->user?->email ?? '—',
                $country,
                $skill,
                $accommodation,
                $room,
                $alloc->status === 'ACTIVE' ? 'تم الوصول والتسكين' : 'قيد الانتظار',
                $alloc->check_in_at ? $alloc->check_in_at->format('Y-m-d H:i') : '—',
            ];
        }

        $filename = 'WSAP_Accommodations_And_Allocations_' . date('Y_m_d_His') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // UTF-8 BOM for Excel Arabic Rendering
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->name_ar        = $this->name_fr = $this->address = $this->contact_phone = '';
        $this->total_capacity = null;
        $this->status         = 'AVAILABLE';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Accommodation::withCount('rooms')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('address', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest();

        $allocationsQuery = RoomAllocation::with([
            'participantProfile.user',
            'participantProfile.registrations.skill',
            'participantProfile.registrations.country',
            'room.accommodation'
        ])
        ->when($this->filterCountry, fn($q) => $q->whereHas('participantProfile.registrations', fn($r) => $r->where('country_id', $this->filterCountry)))
        ->when($this->filterSkill, fn($q) => $q->whereHas('participantProfile.registrations', fn($r) => $r->where('skill_id', $this->filterSkill)))
        ->when($this->filterAccommodation, fn($q) => $q->whereHas('room', fn($r) => $r->where('accommodation_id', $this->filterAccommodation)))
        ->when($this->filterArrivalStatus, fn($q) => $q->where('status', $this->filterArrivalStatus))
        ->latest();

        $modalParticipantsQuery = ParticipantProfile::with(['user.country', 'wilaya', 'registrations.skill', 'registrations.country'])
            ->when($this->allocateCountryId, function ($q) {
                $q->where(function ($sub) {
                    $sub->whereHas('user', fn($u) => $u->where('country_id', $this->allocateCountryId))
                        ->orWhereHas('registrations', fn($r) => $r->where('country_id', $this->allocateCountryId));
                });
            })
            ->when($this->allocateWilayaId, fn($q) => $q->where('wilaya_id', $this->allocateWilayaId));

        $modalRoomsQuery = AccommodationRoom::with('accommodation')
            ->when($this->allocateAccommodationId, fn($q) => $q->where('accommodation_id', $this->allocateAccommodationId));

        return view('livewire.admin.accommodations.index', [
            'accommodations'        => $query->paginate(10),
            'allocations'           => $allocationsQuery->paginate(15, ['*'], 'alloc_page'),
            'totalAccommodations'   => Accommodation::count(),
            'totalCapacity'         => Accommodation::sum('total_capacity'),
            'allParticipants'       => ParticipantProfile::with('user')->get(),
            'allRooms'              => AccommodationRoom::with('accommodation')->get(),
            'countries'             => Country::orderBy('name_ar')->get(),
            'skills'                => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'wilayas'               => \App\Models\Wilaya::orderBy('code')->get(),
            'modalParticipants'     => $modalParticipantsQuery->take(100)->get(),
            'modalRooms'            => $modalRoomsQuery->take(100)->get(),
            'allAccommodationsList' => Accommodation::orderBy('name_ar')->get(),
            'formOpen'              => $this->formOpen,
            'allocateModalOpen'     => $this->allocateModalOpen,
            'roomsFormOpen'         => $this->roomsFormOpen,
            'deleteConfirmOpen'     => $this->deleteConfirmOpen,
            'drawerOpen'            => $this->drawerOpen,
        ]);
    }
}
