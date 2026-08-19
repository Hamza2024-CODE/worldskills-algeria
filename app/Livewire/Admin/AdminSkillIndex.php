<?php

namespace App\Livewire\Admin;

use App\Models\Skill;
use App\Models\SkillCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class AdminSkillIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    public string $search       = '';
    public string $filterCategory = '';
    public string $filterStatus   = '';

    // Form (Create / Edit)
    public bool   $formOpen   = false;
    public bool   $isEditing  = false;
    public ?int   $editingId  = null;

    #[Validate('required|min:2')] public string $name_ar  = '';
    #[Validate('required|min:2')] public string $name_fr  = '';
    #[Validate('nullable')]        public string $name_en  = '';
    #[Validate('nullable')]        public string $description_ar = '';
    #[Validate('nullable')]        public string $description_fr = '';
    #[Validate('nullable')]        public string $description_en = '';
    #[Validate('nullable')]        public string $code       = '';
    #[Validate('nullable|integer')]public ?int   $category_id = null;
    #[Validate('nullable|integer')]public ?int   $min_age   = null;
    #[Validate('nullable|integer')]public ?int   $max_age   = null;
    #[Validate('nullable')]        public string $icon       = '';
    #[Validate('nullable')]        public string $image_path  = '';
    #[Validate('nullable')]        public string $pdf_path    = '';
    public bool   $is_active  = true;
    public int    $sort_order = 0;

    // File Uploads
    public $pdf_file   = null;
    public $image_file = null;

    // Detail Drawer
    public bool   $drawerOpen   = false;
    public ?Skill $selectedSkill = null;

    // PDF Modal Preview
    public bool   $pdfModalOpen  = false;
    public ?string $pdfModalUrl  = null;
    public ?string $pdfModalTitle = null;

    // Delete confirm
    public bool  $deleteConfirmOpen = false;
    public ?int  $deleteTargetId   = null;

    protected $queryString = ['search', 'filterCategory', 'filterStatus'];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void   { $this->resetPage(); }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $this->editingId      = $id;
        $this->name_ar        = $skill->name_ar ?? '';
        $this->name_fr        = $skill->name_fr ?? '';
        $this->name_en        = $skill->name_en ?? '';
        $this->description_ar = $skill->description_ar ?? '';
        $this->description_fr = $skill->description_fr ?? '';
        $this->description_en = $skill->description_en ?? '';
        $this->code           = $skill->code ?? '';
        $this->category_id    = $skill->category_id;
        $this->min_age        = $skill->min_age;
        $this->max_age        = $skill->max_age;
        $this->icon           = $skill->icon ?? '';
        $this->image_path     = $skill->image_path ?? '';
        $this->pdf_path        = $skill->pdf_path ?? '';
        $this->is_active      = (bool) $skill->is_active;
        $this->sort_order     = (int) $skill->sort_order;
        $this->pdf_file       = null;
        $this->image_file     = null;
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function openPdfModal(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $this->pdfModalTitle = $skill->name_ar . ' (' . $skill->code . ')';
        $this->pdfModalUrl   = $skill->getPdfUrl();
        $this->pdfModalOpen  = true;
    }

    public function closePdfModal(): void
    {
        $this->pdfModalOpen  = false;
        $this->pdfModalUrl   = null;
        $this->pdfModalTitle = null;
    }

    public function save(): void
    {
        $this->validate([
            'name_ar'    => 'required|min:2',
            'name_fr'    => 'required|min:2',
            'pdf_file'   => 'nullable|file|mimes:pdf|max:25600',
            'image_file' => 'nullable|image|max:10240',
        ]);

        $data = [
            'name_ar'        => $this->name_ar,
            'name_fr'        => $this->name_fr,
            'name_en'        => $this->name_en ?: $this->name_fr,
            'description_ar' => $this->description_ar,
            'description_fr' => $this->description_fr,
            'description_en' => $this->description_en,
            'code'           => $this->code,
            'category_id'    => $this->category_id ?: null,
            'min_age'        => $this->min_age,
            'max_age'        => $this->max_age,
            'icon'           => $this->icon,
            'image_path'     => $this->image_path,
            'pdf_path'       => $this->pdf_path ?: null,
            'is_active'      => $this->is_active,
            'sort_order'     => $this->sort_order,
        ];

        // Handle Image Upload
        if ($this->image_file) {
            $filename = 'skill_' . time() . '_' . rand(100, 999) . '.' . $this->image_file->getClientOriginalExtension();
            $targetDir = public_path('images/skills');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            copy($this->image_file->getRealPath(), $targetDir . '/' . $filename);
            $data['image_path'] = asset('images/skills/' . $filename);
        }

        if ($this->isEditing) {
            $skill = Skill::findOrFail($this->editingId);
            $skill->update($data);
            $msg = 'تم تحديث بيانات وتفاصيل وصورة التخصص بنجاح';
        } else {
            $skill = Skill::create($data);
            $msg = 'تم إضافة التخصص الجديد بنجاح';
        }

        // Upload custom PDF if attached
        if ($this->pdf_file) {
            $code = $skill->code ?: ('SKILL-' . str_pad($skill->id, 2, '0', STR_PAD_LEFT));
            if (preg_match('/(?:SKILL|TD)-?(\d+)/i', $code, $m)) {
                $num = str_pad($m[1], 2, '0', STR_PAD_LEFT);
                $filename = "WSC2026_TD{$num}_en.pdf";
            } else {
                $filename = "WSC2026_{$code}_en.pdf";
            }

            $targetDir = public_path('docs/td');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            copy($this->pdf_file->getRealPath(), $targetDir . '/' . $filename);
            $savedPdfPath = 'docs/td/' . $filename;
            $skill->update(['pdf_path' => $savedPdfPath]);
            $msg .= ' وتحديث ملف التوصيف الفني PDF بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $skill->update(['is_active' => !$skill->is_active]);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteSkill(): void
    {
        Skill::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف التخصص']);
    }

    public function openDrawer(int $id): void
    {
        $this->selectedSkill = Skill::with('category')->find($id);
        $this->drawerOpen    = true;
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name_ar = $this->name_fr = $this->name_en = '';
        $this->description_ar = $this->description_fr = $this->description_en = '';
        $this->code = $this->icon = $this->image_path = $this->pdf_path = '';
        $this->category_id = null;
        $this->min_age = $this->max_age = null;
        $this->is_active  = true;
        $this->sort_order = 0;
        $this->pdf_file   = null;
        $this->image_file = null;
        $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $skills = Skill::with('category')->orderBy('name_ar')->get();

        $csvData = [];
        $csvData[] = ['#ID', 'كود التخصص', 'اسم التخصص المهني بالعربية', 'الاسم بالفرنسية', 'الفئة', 'الحد الأدنى للأعمار', 'الحد الأقصى للأعمار', 'ملف PDF المرفق', 'حالة التخصص'];

        foreach ($skills as $s) {
            $csvData[] = [
                $s->id,
                $s->code ?: '—',
                $s->name_ar,
                $s->name_fr,
                $s->category?->name_ar ?? '—',
                $s->min_age ?? 16,
                $s->max_age ?? 25,
                $s->getPdfUrl() ? 'موجود ورسمي' : 'غير متوفر',
                $s->is_active ? 'معتمد ونشط' : 'معطل',
            ];
        }

        $filename = 'WSAP_Trade_Skills_' . date('Y_m_d_His') . '.csv';

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
        $query = Skill::with('category')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('name_en', 'like', '%'.$this->search.'%')
                  ->orWhere('code',    'like', '%'.$this->search.'%');
            }))
            ->when($this->filterCategory, fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->orderBy('sort_order')
            ->orderBy('code');

        return view('livewire.admin.skills.index', [
            'skills'       => $query->paginate(20),
            'categories'   => SkillCategory::orderBy('name_ar')->get(),
            'totalSkills'  => Skill::count(),
            'activeSkills' => Skill::where('is_active', true)->count(),
        ]);
    }
}
