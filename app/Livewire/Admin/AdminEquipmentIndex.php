<?php

namespace App\Livewire\Admin;

use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminEquipmentIndex extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $filterCategory = '';
    public string $filterSkill    = '';
    public string $filterType     = '';

    // Category form
    public bool   $catFormOpen   = false;
    public bool   $catEditing    = false;
    public ?int   $catEditingId  = null;
    public string $cat_name_ar   = '';
    public string $cat_name_fr   = '';
    public string $cat_icon      = '';

    // Item form
    public bool   $formOpen   = false;
    public bool   $isEditing  = false;
    public ?int   $editingId  = null;

    #[Validate('required|min:2')]  public string $name_ar              = '';
    #[Validate('required|min:2')]  public string $name_fr              = '';
    #[Validate('nullable')]        public string $name_en              = '';
    #[Validate('nullable|integer')]public ?int   $category_id          = null;
    #[Validate('nullable|integer')]public ?int   $skill_id             = null;
    #[Validate('nullable')]        public string $item_type            = '';
    #[Validate('nullable')]        public string $specification_details = '';
    #[Validate('nullable')]        public string $safety_level         = '';

    // Drawer
    public bool           $drawerOpen   = false;
    public ?EquipmentItem $selectedItem = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterCategory', 'filterSkill', 'filterType'];

    public function updatingSearch(): void         { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void    { $this->resetPage(); }
    public function updatingFilterType(): void     { $this->resetPage(); }

    /* ─── Category Handlers ─── */
    public function openCatCreate(): void
    {
        $this->cat_name_ar  = '';
        $this->cat_name_fr  = '';
        $this->cat_icon     = '';
        $this->catEditingId = null;
        $this->catEditing   = false;
        $this->catFormOpen  = true;
    }

    public function openCatEdit(int $id): void
    {
        $cat = EquipmentCategory::findOrFail($id);
        $this->catEditingId = $cat->id;
        $this->cat_name_ar  = $cat->name_ar ?? '';
        $this->cat_name_fr  = $cat->name_fr ?? '';
        $this->cat_icon     = $cat->icon ?? '';
        $this->catEditing   = true;
        $this->catFormOpen  = true;
    }

    public function saveCat(): void
    {
        $this->validate([
            'cat_name_ar' => 'required|min:2',
            'cat_name_fr' => 'required|min:2'
        ]);
        $data = [
            'name_ar' => $this->cat_name_ar,
            'name_fr' => $this->cat_name_fr,
            'name_en' => $this->cat_name_fr,
            'icon'    => $this->cat_icon ?: 'wrench'
        ];

        $this->catEditing
            ? EquipmentCategory::findOrFail($this->catEditingId)->update($data)
            : EquipmentCategory::create($data);

        $this->catFormOpen = false;
        session()->flash('success', 'تم حفظ فئة التجهيزات والمعدات بنجاح.');
    }

    public function deleteCat(int $id): void
    {
        $cat = EquipmentCategory::withCount('items')->findOrFail($id);
        if ($cat->items_count > 0) {
            session()->flash('error', 'لا يمكن حذف الفئة لأنها تحتوي على معدات وتجهيزات مسجلة.');
            return;
        }
        $cat->delete();
        session()->flash('success', 'تم حذف الفئة بنجاح.');
    }

    /* ─── Item Handlers ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $item = EquipmentItem::findOrFail($id);
        $this->editingId              = $id;
        $this->name_ar                = $item->name_ar ?? '';
        $this->name_fr                = $item->name_fr ?? '';
        $this->name_en                = $item->name_en ?? '';
        $this->category_id            = $item->category_id;
        $this->skill_id               = $item->skill_id;
        $this->item_type              = $item->item_type ?? '';
        $this->specification_details  = $item->specification_details ?? '';
        $this->safety_level           = $item->safety_level ?? '';
        $this->isEditing              = true;
        $this->formOpen               = true;
    }

    public function save(): void
    {
        $this->validate([
            'name_ar' => 'required|min:2',
            'name_fr' => 'required|min:2'
        ]);
        $data = [
            'name_ar'               => $this->name_ar,
            'name_fr'               => $this->name_fr,
            'name_en'               => $this->name_en ?: $this->name_fr,
            'category_id'           => $this->category_id ?: null,
            'skill_id'              => $this->skill_id ?: null,
            'item_type'             => $this->item_type ?: 'workstation',
            'specification_details' => $this->specification_details,
            'safety_level'          => $this->safety_level ?: 'STANDARD',
        ];

        $this->isEditing
            ? EquipmentItem::findOrFail($this->editingId)->update($data)
            : EquipmentItem::create($data);

        $this->formOpen = false;
        $this->resetForm();
        session()->flash('success', $this->isEditing ? 'تم تحديث تجهيز التخصص بنجاح.' : 'تمت إضافة التجهيز والمعدة بنجاح.');
    }

    public function openDrawer(int $id): void
    {
        $this->selectedItem = EquipmentItem::with(['category', 'skill'])->find($id);
        $this->drawerOpen   = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteItem(): void
    {
        EquipmentItem::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        session()->flash('success', 'تم حذف المعدة بنجاح.');
    }

    /* ─── Platform Excel Export ─── */
    public function exportExcel()
    {
        $items = EquipmentItem::with(['category', 'skill'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('specification_details', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterSkill,    fn($q) => $q->where('skill_id',    $this->filterSkill))
            ->when($this->filterType,     fn($q) => $q->where('item_type',    $this->filterType))
            ->latest()
            ->get();

        $csvData = [];
        $csvData[] = [
            'ID',
            'اسم المعدة والتجهيز',
            'الاسم بالفرنسية',
            'التخصص المهني المخصص',
            'رمز التخصص',
            'الفئة الرئيسية',
            'نوع التجهيز',
            'المواصفات الفنية والتفاصيل',
            'مستوى السلامة والوقاية'
        ];

        foreach ($items as $item) {
            $csvData[] = [
                $item->id,
                $item->name_ar,
                $item->name_fr ?? '',
                $item->skill?->name_ar ?? 'عام / كافة التخصصات',
                $item->skill?->code ?? '—',
                $item->category?->name_ar ?? '—',
                $item->item_type ?? 'عام',
                $item->specification_details ?? '—',
                $item->safety_level ?? 'STANDARD',
            ];
        }

        $filename = 'WSAP_Trade_Skills_Equipment_' . date('Y_m_d_His') . '.csv';

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

    private function resetForm(): void
    {
        $this->editingId   = null;
        $this->name_ar     = $this->name_fr = $this->name_en = '';
        $this->category_id = $this->skill_id = null;
        $this->item_type   = $this->specification_details = $this->safety_level = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = EquipmentItem::with(['category', 'skill'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('specification_details', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterSkill,    fn($q) => $q->where('skill_id',    $this->filterSkill))
            ->when($this->filterType,     fn($q) => $q->where('item_type',    $this->filterType))
            ->latest();

        return view('livewire.admin.equipment.index', [
            'items'               => $query->paginate(15),
            'categories'          => EquipmentCategory::withCount('items')->orderBy('name_ar')->get(),
            'skills'              => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'totalItems'          => EquipmentItem::count(),
            'assignedItemsCount'  => EquipmentItem::whereNotNull('skill_id')->count(),
            'generalItemsCount'   => EquipmentItem::whereNull('skill_id')->count(),
            'hazardItemsCount'    => EquipmentItem::whereIn('safety_level', ['HIGH_HAZARD', 'STRICT_PPE_REQUIRED'])->count(),
        ]);
    }
}
