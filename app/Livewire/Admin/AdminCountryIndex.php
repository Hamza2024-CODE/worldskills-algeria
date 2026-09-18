<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\Registration;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminCountryIndex extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = '';
    public string $filterScope = ''; // 'all', 'africa', 'international'
    public string $filterHasRegs = ''; // 'all', 'with_regs', 'without_regs'

    // Selection for Bulk Actions
    public array $selectedCountries = [];
    public bool $selectAll = false;

    // Modals & Drawers
    public bool $formOpen = false;
    public bool $isEditing = false;
    public ?int $editingId = null;

    public bool $drawerOpen = false;
    public ?Country $selected = null;

    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId = null;

    // Form fields
    #[Validate('required|min:2')]
    public string $name_ar = '';

    #[Validate('required|min:2')]
    public string $name_fr = '';

    public string $name_en = '';
    public string $nationality_ar = '';
    public string $nationality_fr = '';
    public string $nationality_en = '';
    public string $iso2 = '';
    public string $iso3 = '';
    public string $phone_code = '';
    public string $flag = '';
    public bool $is_african = true;
    public bool $requires_passport = false;
    public bool $is_active = true;

    protected $queryString = ['search', 'filterStatus', 'filterScope', 'filterHasRegs'];

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterScope(): void { $this->resetPage(); }
    public function updatingFilterHasRegs(): void { $this->resetPage(); }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedCountries = $this->getFilteredQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedCountries = [];
        }
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen = true;
    }

    public function openEdit(int $id): void
    {
        $country = Country::findOrFail($id);
        $this->editingId           = $id;
        $this->name_ar             = $country->name_ar ?? '';
        $this->name_fr             = $country->name_fr ?? '';
        $this->name_en             = $country->name_en ?? '';
        $this->nationality_ar      = $country->nationality_ar ?? '';
        $this->nationality_fr      = $country->nationality_fr ?? '';
        $this->nationality_en      = $country->nationality_en ?? '';
        $this->iso2                = $country->iso2 ?? '';
        $this->iso3                = $country->iso3 ?? '';
        $this->phone_code          = $country->phone_code ?? '';
        $this->flag                = $country->flag ?? '';
        $this->is_african          = (bool)($country->is_african ?? true);
        $this->requires_passport   = (bool)($country->requires_passport ?? false);
        $this->is_active           = (bool)($country->is_active ?? true);
        
        $this->isEditing           = true;
        $this->formOpen            = true;
    }

    public function save(): void
    {
        $this->validate([
            'name_ar' => 'required|min:2',
            'name_fr' => 'required|min:2',
        ]);

        $data = [
            'name_ar'           => $this->name_ar,
            'name_fr'           => $this->name_fr,
            'name_en'           => $this->name_en ?: $this->name_fr,
            'nationality_ar'    => $this->nationality_ar,
            'nationality_fr'    => $this->nationality_fr,
            'nationality_en'    => $this->nationality_en,
            'iso2'              => strtoupper($this->iso2),
            'iso3'              => strtoupper($this->iso3),
            'phone_code'        => $this->phone_code,
            'flag'              => $this->flag,
            'is_african'        => $this->is_african,
            'requires_passport' => $this->requires_passport,
            'is_active'          => $this->is_active,
        ];

        if ($this->isEditing) {
            Country::findOrFail($this->editingId)->update($data);
            $msg = 'تم تحديث بيانات الدولة بنجاح';
        } else {
            Country::create($data);
            $msg = 'تم إضافة الدولة الجديدة بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive(int $id): void
    {
        $c = Country::findOrFail($id);
        $c->update(['is_active' => !$c->is_active]);
        $this->dispatch('notify', ['type' => 'info', 'msg' => 'تم تغيير حالة التفعيل للفيـلـق/الدولة']);
    }

    public function bulkToggleActive(bool $status): void
    {
        if (empty($this->selectedCountries)) {
            $this->dispatch('notify', ['type' => 'warning', 'msg' => 'يرجى تحديد دول أولاً']);
            return;
        }

        Country::whereIn('id', $this->selectedCountries)->update(['is_active' => $status]);
        $this->selectedCountries = [];
        $this->selectAll = false;
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تحديث حالة الدول المحددة']);
    }

    public function openDrawer(int $id): void
    {
        $this->selected = Country::withCount(['registrations', 'users'])->find($id);
        $this->drawerOpen = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteCountry(): void
    {
        $c = Country::findOrFail($this->deleteTargetId);
        
        // Prevent deletion if country has registrations
        if ($c->registrations()->count() > 0) {
            $this->deleteConfirmOpen = false;
            $this->dispatch('notify', ['type' => 'error', 'msg' => 'عذراً، لا يمكن حذف هذه الدولة لاحتوائها على مسجلين معتمدين.']);
            return;
        }

        $c->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الدولة بنجاح']);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name_ar = $this->name_fr = $this->name_en = '';
        $this->nationality_ar = $this->nationality_fr = $this->nationality_en = '';
        $this->iso2 = $this->iso3 = $this->phone_code = $this->flag = '';
        $this->is_african = true;
        $this->requires_passport = false;
        $this->is_active = true;
        $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $countries = $this->getFilteredQuery()->get();

        $csvData = [];
        $csvData[] = ['#ID', 'الرمز ISO2', 'الرمز ISO3', 'اسم الدولة (عربي)', 'اسم الدولة (فرنسي)', 'اسم الدولة (إنجليزي)', 'رمز الهاتف', 'النطاق الجغرافي', 'عدد المسجلين', 'الحالة'];

        foreach ($countries as $c) {
            $csvData[] = [
                $c->id,
                $c->iso2 ?: '—',
                $c->iso3 ?: '—',
                $c->name_ar,
                $c->name_fr,
                $c->name_en ?: $c->name_fr,
                $c->phone_code ?: '—',
                $c->is_african ? 'إفريقية 🌍' : 'دولية 🌐',
                $c->registrations_count ?? 0,
                $c->is_active ? 'نشطة ومتاحة للتسجيل' : 'معطلة',
            ];
        }

        $filename = 'WSAP_Countries_' . date('Y_m_d_His') . '.csv';

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
        return Country::withCount(['registrations'])
            ->when($this->search !== '', fn($q) => $q->where(fn($sub) =>
                $sub->where('name_ar', 'like', '%'.$this->search.'%')
                    ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                    ->orWhere('name_en', 'like', '%'.$this->search.'%')
                    ->orWhere('iso2', 'like', '%'.$this->search.'%')
                    ->orWhere('iso3', 'like', '%'.$this->search.'%')
                    ->orWhere('phone_code', 'like', '%'.$this->search.'%')
            ))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->when($this->filterScope === 'africa', fn($q) => $q->where('is_african', true))
            ->when($this->filterScope === 'international', fn($q) => $q->where('is_african', false))
            ->when($this->filterHasRegs === 'with_regs', fn($q) => $q->has('registrations'))
            ->when($this->filterHasRegs === 'without_regs', fn($q) => $q->doesntHave('registrations'))
            ->orderBy('is_african', 'desc')
            ->orderBy('name_ar');
    }

    public function render()
    {
        $query = $this->getFilteredQuery();

        return view('livewire.admin.countries.index', [
            'countries'           => $query->paginate(20),
            'totalCountries'     => Country::count(),
            'activeCountries'    => Country::where('is_active', true)->count(),
            'africanCountries'   => Country::where('is_african', true)->count(),
            'totalRegistrations' => Registration::count(),
        ]);
    }
}
