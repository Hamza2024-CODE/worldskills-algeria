<?php

namespace App\Livewire\Admin;

use App\Models\Edition;
use App\Models\EditionDate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminEditionIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|integer|min:2020|max:2099')] 
    public ?int $year = null;

    #[Validate('required|string|min:2|max:255')] 
    public string $name_ar = '';

    #[Validate('required|string|min:2|max:255')] 
    public string $name_fr = '';

    #[Validate('nullable|string|max:255')] 
    public string $name_en = '';

    #[Validate('required|string')] 
    public string $status = 'ACTIVE';

    public bool $is_active = false;

    // Dates sub-form
    public array $dates = [];

    // Detail Drawer
    public bool     $drawerOpen      = false;
    public ?Edition $selectedEdition = null;

    // Delete Modal
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->year      = (int) date('Y');
        $this->status    = 'ACTIVE';
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $e = Edition::with('dates')->findOrFail($id);
        $this->editingId = $id;
        $this->year      = $e->year;
        $this->name_ar   = $e->name_ar ?? '';
        $this->name_fr   = $e->name_fr ?? '';
        $this->name_en   = $e->name_en ?? '';
        $this->status    = $e->status ?? 'ACTIVE';
        $this->is_active = (bool) $e->is_active;

        $this->dates     = $e->dates->map(fn($d) => [
            'id'          => $d->id,
            'date_type'   => $d->date_type ?? 'EVENT',
            'location_ar' => $d->location_ar ?? '',
            'location_fr' => $d->location_fr ?? '',
            'start_at'    => $d->start_at?->format('Y-m-d') ?? '',
            'end_at'      => $d->end_at?->format('Y-m-d') ?? '',
        ])->toArray();

        $this->isEditing = true;
        $this->formOpen  = true;
    }

    public function addDate(): void
    {
        $this->dates[] = [
            'id'          => null,
            'date_type'   => 'EVENT',
            'location_ar' => '',
            'location_fr' => '',
            'start_at'    => '',
            'end_at'      => ''
        ];
    }

    public function removeDate(int $idx): void
    {
        unset($this->dates[$idx]);
        $this->dates = array_values($this->dates);
    }

    public function save(): void
    {
        $this->validate([
            'year'    => 'required|integer|min:2020|max:2099',
            'name_ar' => 'required|min:2|max:255',
            'name_fr' => 'required|min:2|max:255',
            'status'  => 'required|string',
        ]);

        $data = [
            'year'      => $this->year,
            'name_ar'   => $this->name_ar,
            'name_fr'   => $this->name_fr,
            'name_en'   => $this->name_en ?: $this->name_fr,
            'status'    => $this->status,
            'is_active' => $this->is_active,
        ];

        if ($this->is_active) {
            // Deactivate all other editions if this one is set active
            if ($this->isEditing) {
                Edition::where('id', '!=', $this->editingId)->update(['is_active' => false]);
            } else {
                Edition::query()->update(['is_active' => false]);
            }
        }

        if ($this->isEditing) {
            $edition = Edition::findOrFail($this->editingId);
            $edition->update($data);
            $edition->dates()->delete();
        } else {
            $edition = Edition::create($data);
        }

        foreach ($this->dates as $date) {
            if (!empty($date['start_at'])) {
                $edition->dates()->create([
                    'date_type'   => $date['date_type'] ?? 'EVENT',
                    'location_ar' => $date['location_ar'] ?? '',
                    'location_fr' => $date['location_fr'] ?? '',
                    'start_at'    => $date['start_at'],
                    'end_at'      => !empty($date['end_at']) ? $date['end_at'] : null,
                ]);
            }
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $this->isEditing ? 'تم تحديث الدورة بنجاح' : 'تم إضافة الدورة بنجاح']);
    }

    public function toggleActive(int $id): void
    {
        $edition = Edition::findOrFail($id);
        if (!$edition->is_active) {
            Edition::where('id', '!=', $id)->update(['is_active' => false]);
            $edition->update(['is_active' => true]);
        } else {
            $edition->update(['is_active' => false]);
        }
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تعديل حالة تفعيل الطبعة']);
    }

    public function openDrawer(int $id): void
    {
        $this->selectedEdition = Edition::with(['dates', 'countries'])->withCount(['registrations'])->find($id);
        $this->drawerOpen      = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteEdition(): void
    {
        if ($this->deleteTargetId) {
            Edition::findOrFail($this->deleteTargetId)->delete();
            $this->deleteConfirmOpen = false;
            $this->deleteTargetId    = null;
            $this->resetPage();
            $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الطبعة بنجاح']);
        }
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->year      = null;
        $this->name_ar   = '';
        $this->name_fr   = '';
        $this->name_en   = '';
        $this->status    = 'ACTIVE';
        $this->is_active = false;
        $this->dates     = [];
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Edition::withCount(['registrations', 'countries'])
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('name_ar', 'like', '%'.$this->search.'%')
                       ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                       ->orWhere('name_en', 'like', '%'.$this->search.'%')
                       ->orWhere('year',    'like', '%'.$this->search.'%');
                });
            })
            ->when($this->filterStatus, function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->orderByDesc('year');

        return view('livewire.admin.editions.index', [
            'editions'        => $query->paginate(10),
            'totalEditions'   => Edition::count(),
            'activeEdition'   => Edition::where('is_active', true)->first(),
            'activeCount'     => Edition::where('is_active', true)->count(),
            'completedCount'  => Edition::where('status', 'COMPLETED')->count(),
            'draftCount'      => Edition::where('status', 'DRAFT')->count(),
        ]);
    }
}
