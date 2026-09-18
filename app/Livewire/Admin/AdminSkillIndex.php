<?php

namespace App\Livewire\Admin;

use App\Models\Skill;
use App\Models\SkillCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminSkillIndex extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $filterCategory = '';
    public string $filterStatus = ''; // '1' active, '0' inactive
    public string $filterHomepageStatus = ''; // '1' visible, '0' hidden
    public string $filterPdfStatus = ''; // 'has_pdf', 'no_pdf'

    // Form Modals & Drawer
    public bool $formOpen = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    public bool $drawerOpen = false;
    public ?Skill $selectedSkill = null;

    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId = null;

    // In-App PDF Viewer Modal State
    public bool $pdfModalOpen = false;
    public ?string $pdfModalTitle = null;
    public ?string $pdfModalUrl = null;

    // Form fields
    #[Validate('required|min:2')]
    public string $name_ar = '';

    #[Validate('required|min:2')]
    public string $name_fr = '';

    public string $name_en = '';
    public string $description_ar = '';
    public string $description_fr = '';
    public string $description_en = '';
    public string $code = '';
    public ?int $category_id = null;
    public ?int $min_age = 16;
    public ?int $max_age = 25;
    public string $icon = '';
    public string $image_path = '';
    public string $pdf_path = '';
    public string $selected_existing_pdf = '';
    public bool $is_active = true;
    public bool $show_on_homepage = true;
    public int $sort_order = 0;

    public $pdf_file = null;
    public $image_file = null;

    protected $queryString = ['search', 'filterCategory', 'filterStatus', 'filterHomepageStatus', 'filterPdfStatus'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterCategory(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterHomepageStatus(): void { $this->resetPage(); }
    public function updatingFilterPdfStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen = true;
    }

    public function openEdit(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $this->editingId             = $id;
        $this->name_ar               = $skill->name_ar ?? '';
        $this->name_fr               = $skill->name_fr ?? '';
        $this->name_en               = $skill->name_en ?? '';
        $this->description_ar        = $skill->description_ar ?? '';
        $this->description_fr        = $skill->description_fr ?? '';
        $this->description_en        = $skill->description_en ?? '';
        $this->code                  = $skill->code ?? '';
        $this->category_id           = $skill->category_id;
        $this->min_age               = $skill->min_age ?? 16;
        $this->max_age               = $skill->max_age ?? 25;
        $this->icon                  = $skill->icon ?? '';
        $this->image_path            = $skill->image_path ?? '';
        $this->pdf_path              = $skill->pdf_path ?? '';
        $this->selected_existing_pdf = $skill->pdf_path ?? '';
        $this->is_active             = (bool) $skill->is_active;
        $this->show_on_homepage      = (bool) ($skill->show_on_homepage ?? true);
        $this->sort_order            = (int) $skill->sort_order;
        
        $this->pdf_file              = null;
        $this->image_file            = null;
        $this->isEditing             = true;
        $this->formOpen              = true;
    }

    public function openPdfModal(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $pdfUrl = $skill->getPdfUrl();

        if (!$pdfUrl) {
            $this->dispatch('notify', ['type' => 'error', 'msg' => 'عذراً، لا يوجد ملف توصيف فني PDF مرفق بهذا التخصص حالياً.']);
            return;
        }

        $this->pdfModalTitle = $skill->name_ar . ' (' . ($skill->code ?: 'Skill-' . $skill->id) . ')';
        $this->pdfModalUrl   = $pdfUrl;
        $this->pdfModalOpen  = true;
    }

    public function closePdfModal(): void
    {
        $this->pdfModalOpen  = false;
        $this->pdfModalUrl   = null;
        $this->pdfModalTitle = null;
    }

    public function toggleActive(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $skill->update(['is_active' => !$skill->is_active]);
        $this->dispatch('notify', [
            'type' => 'info',
            'msg'  => 'تم تغيير حالة تفعيل التخصص في التسجيلات'
        ]);
    }

    public function toggleHomepage(int $id): void
    {
        $skill = Skill::findOrFail($id);
        $newVal = !($skill->show_on_homepage ?? true);
        $skill->update(['show_on_homepage' => $newVal]);
        $this->dispatch('notify', [
            'type' => 'success',
            'msg'  => $newVal ? 'تم إظهار التخصص في الصفحة الرئيسية' : 'تم إخفاء التخصص من الصفحة الرئيسية'
        ]);
    }

    public function save(): void
    {
        $this->validate([
            'name_ar'    => 'required|min:2',
            'name_fr'    => 'required|min:2',
            'pdf_file'   => 'nullable|file|mimes:pdf|max:30720',
            'image_file' => 'nullable|image|max:12288',
        ]);

        $finalPdfPath = $this->pdf_path;

        // If chosen from existing platform PDFs dropdown
        if (!empty($this->selected_existing_pdf)) {
            $finalPdfPath = $this->selected_existing_pdf;
        }

        $data = [
            'name_ar'          => $this->name_ar,
            'name_fr'          => $this->name_fr,
            'name_en'          => $this->name_en ?: $this->name_fr,
            'description_ar'   => $this->description_ar,
            'description_fr'   => $this->description_fr,
            'description_en'   => $this->description_en,
            'code'             => strtoupper(trim($this->code)),
            'category_id'      => $this->category_id ?: null,
            'min_age'          => $this->min_age,
            'max_age'          => $this->max_age,
            'icon'             => $this->icon,
            'image_path'       => $this->image_path,
            'pdf_path'         => $finalPdfPath ?: null,
            'is_active'        => $this->is_active,
            'show_on_homepage' => $this->show_on_homepage,
            'sort_order'       => $this->sort_order,
        ];

        // Handle Image Upload
        if ($this->image_file) {
            $filename = 'skill_' . time() . '_' . rand(100, 999) . '.' . $this->image_file->getClientOriginalExtension();
            $targetDir = public_path('images/skills');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            copy($this->image_file->getRealPath(), $targetDir . '/' . $filename);
            $data['image_path'] = 'images/skills/' . $filename;
        }

        if ($this->isEditing) {
            $skill = Skill::findOrFail($this->editingId);
            $skill->update($data);
            $msg = 'تم تحديث بيانات التخصص وصورته بنجاح';
        } else {
            $skill = Skill::create($data);
            $msg = 'تم إضافة التخصص الجديد بنجاح';
        }

        // Handle PDF File Upload if provided
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
            $msg .= ' وحفظ ملف التوصيف الفني PDF بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
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
        $this->selectedSkill = Skill::with(['category', 'registrations'])->find($id);
        $this->drawerOpen    = true;
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name_ar = $this->name_fr = $this->name_en = '';
        $this->description_ar = $this->description_fr = $this->description_en = '';
        $this->code = $this->icon = $this->image_path = $this->pdf_path = $this->selected_existing_pdf = '';
        $this->category_id = null;
        $this->min_age = 16;
        $this->max_age = 25;
        $this->is_active = true;
        $this->show_on_homepage = true;
        $this->sort_order = 0;
        $this->pdf_file   = null;
        $this->image_file = null;
        $this->resetErrorBag();
    }

    public function getAvailablePdfsProperty(): array
    {
        $dir = public_path('docs/td');
        if (!file_exists($dir)) return [];
        $files = glob($dir . '/*.pdf');
        return array_map(fn($f) => 'docs/td/' . basename($f), $files);
    }

    public function exportExcel()
    {
        $skills = $this->getFilteredQuery()->get();

        $csvData = [];
        $csvData[] = ['#ID', 'كود التخصص', 'اسم التخصص بالعربية', 'الاسم بالفرنسية', 'القطاع/الفئة', 'العمر المسموح', 'ملف التوصيف PDF', 'العرض بالصفحة الرئيسية', 'حالة التخصص'];

        foreach ($skills as $s) {
            $csvData[] = [
                $s->id,
                $s->code ?: '—',
                $s->name_ar,
                $s->name_fr,
                $s->category?->name_ar ?? '—',
                ($s->min_age ?? 16) . ' - ' . ($s->max_age ?? 25) . ' سنة',
                $s->getPdfUrl() ? 'متوفر ورسمي' : 'غير متوفر',
                ($s->show_on_homepage ?? true) ? 'ظاهر بالصفحة الرئيسية' : 'مخفي',
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

    private function getFilteredQuery()
    {
        return Skill::with(['category', 'registrations'])
            ->when($this->search !== '', fn($q) => $q->where(function ($sub) {
                $sub->where('name_ar', 'like', '%'.$this->search.'%')
                    ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                    ->orWhere('name_en', 'like', '%'.$this->search.'%')
                    ->orWhere('code',    'like', '%'.$this->search.'%');
            }))
            ->when($this->filterCategory !== '', fn($q) => $q->where('category_id', $this->filterCategory))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->when($this->filterHomepageStatus !== '', fn($q) => $q->where('show_on_homepage', $this->filterHomepageStatus === '1'))
            ->when($this->filterPdfStatus === 'has_pdf', fn($q) => $q->where(fn($sub) => $sub->whereNotNull('pdf_path')->orWhere('code', 'like', 'SKILL-%')))
            ->when($this->filterPdfStatus === 'no_pdf', fn($q) => $q->whereNull('pdf_path'))
            ->orderBy('sort_order')
            ->orderBy('code');
    }

    public function render()
    {
        $query = $this->getFilteredQuery();

        return view('livewire.admin.skills.index', [
            'skills'                   => $query->paginate(20),
            'categories'               => SkillCategory::orderBy('name_ar')->get(),
            'totalSkills'              => Skill::count(),
            'activeSkills'             => Skill::where('is_active', true)->count(),
            'homepageSkillsCount'      => Skill::where('show_on_homepage', true)->count(),
            'skillsWithPdfCount'       => Skill::whereNotNull('pdf_path')->orWhere('code', 'like', 'SKILL-%')->count(),
        ]);
    }
}
