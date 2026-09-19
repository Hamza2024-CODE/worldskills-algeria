<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\Edition;
use App\Models\Organization;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminReportsIndex extends Component
{
    public $selectedEdition = 'all';
    public $selectedStatus = 'all';
    public $dateFrom = '';
    public $dateTo = '';

    public function resetFilters()
    {
        $this->selectedEdition = 'all';
        $this->selectedStatus = 'all';
        $this->dateFrom = '';
        $this->dateTo = '';
    }

    public function exportReportsCsv()
    {
        $query = Registration::query();

        if ($this->selectedEdition !== 'all') {
            $query->where('edition_id', $this->selectedEdition);
        }

        if ($this->selectedStatus !== 'all') {
            $query->where('status', $this->selectedStatus);
        }

        if (!empty($this->dateFrom)) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $totalRegs = (clone $query)->count();
        $approvedCount = (clone $query)->where('status', 'APPROVED')->count();
        $qualifiedRegCount = (clone $query)->where('status', 'QUALIFIED_REGIONAL')->count();
        $qualifiedNatCount = (clone $query)->where('status', 'QUALIFIED_NATIONAL')->count();
        $pendingCount = (clone $query)->where('status', 'PENDING')->count();
        $rejectedCount = (clone $query)->where('status', 'REJECTED')->count();

        $filename = 'worldskills_national_report_' . date('Y_m_d_H_i') . '.csv';

        return response()->streamDownload(function () use (
            $totalRegs, $approvedCount, $qualifiedRegCount, $qualifiedNatCount, $pendingCount, $rejectedCount
        ) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel Arabic compatibility
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['--- التقرير الوطني والإحصائي لمهارات الجزائر (WorldSkills Algeria) ---']);
            fputcsv($handle, ['تاريخ التصدير', date('Y-m-d H:i:s')]);
            fputcsv($handle, []);

            // Overall Summary
            fputcsv($handle, ['--- مؤشرات الأداء الرئيسية (KPIs) ---']);
            fputcsv($handle, ['المؤشر', 'العدد الإجمالي']);
            fputcsv($handle, ['إجمالي التسجيلات', $totalRegs]);
            fputcsv($handle, ['التسجيلات المقبولة (APPROVED)', $approvedCount]);
            fputcsv($handle, ['المتأهلون إقليمياً (QUALIFIED_REGIONAL)', $qualifiedRegCount]);
            fputcsv($handle, ['المتأهلون وطنياً (QUALIFIED_NATIONAL)', $qualifiedNatCount]);
            fputcsv($handle, ['طلبات قيد الدراسة (PENDING)', $pendingCount]);
            fputcsv($handle, ['الطلبات المرفوضة (REJECTED)', $rejectedCount]);
            fputcsv($handle, ['إجمالي الحسابات المسجلة', User::count()]);
            fputcsv($handle, ['إجمالي التخصصات الأولمبية', Skill::count()]);
            fputcsv($handle, ['إجمالي الولايات', Wilaya::count()]);
            fputcsv($handle, ['إجمالي المؤسسات التكوينية', Organization::count()]);
            fputcsv($handle, []);

            // Top Wilayas
            fputcsv($handle, ['--- توزيع التسجيلات حسب الولايات ---']);
            fputcsv($handle, ['رمز الولاية', 'اسم الولاية بالعربية', 'اسم الولاية بالفرنسية', 'عدد التسجيلات']);
            $topWilayas = Wilaya::withCount('registrations')
                ->orderByDesc('registrations_count')
                ->get();
            foreach ($topWilayas as $w) {
                fputcsv($handle, [
                    sprintf('%02d', $w->code ?? $w->id),
                    $w->name_ar ?? $w->name,
                    $w->name_fr ?? '',
                    $w->registrations_count
                ]);
            }
            fputcsv($handle, []);

            // Top Skills
            fputcsv($handle, ['--- توزيع التسجيلات حسب التخصصات المهارية ---']);
            fputcsv($handle, ['رمز التخصص', 'اسم التخصص بالعربية', 'اسم التخصص بالإنكليزية', 'عدد المترشحين']);
            $topSkills = Skill::withCount('registrations')
                ->orderByDesc('registrations_count')
                ->get();
            foreach ($topSkills as $s) {
                fputcsv($handle, [
                    $s->code ?? $s->id,
                    $s->name_ar ?? $s->name,
                    $s->name_en ?? '',
                    $s->registrations_count
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        $baseQuery = Registration::query();

        if ($this->selectedEdition !== 'all') {
            $baseQuery->where('edition_id', $this->selectedEdition);
        }

        if ($this->selectedStatus !== 'all') {
            $baseQuery->where('status', $this->selectedStatus);
        }

        if (!empty($this->dateFrom)) {
            $baseQuery->whereDate('created_at', '>=', $this->dateFrom);
        }

        if (!empty($this->dateTo)) {
            $baseQuery->whereDate('created_at', '<=', $this->dateTo);
        }

        $totalRegistrations = (clone $baseQuery)->count();
        $approvedRegs       = (clone $baseQuery)->where('status', 'APPROVED')->count();
        $qualifiedRegRegs   = (clone $baseQuery)->where('status', 'QUALIFIED_REGIONAL')->count();
        $qualifiedNatRegs   = (clone $baseQuery)->where('status', 'QUALIFIED_NATIONAL')->count();
        $pendingRegs        = (clone $baseQuery)->where('status', 'PENDING')->count();
        $rejectedRegs       = (clone $baseQuery)->where('status', 'REJECTED')->count();

        $topWilayas = Wilaya::withCount(['registrations' => function ($q) {
            if ($this->selectedEdition !== 'all') {
                $q->where('edition_id', $this->selectedEdition);
            }
        }])
        ->orderByDesc('registrations_count')
        ->take(12)
        ->get();

        $topSkills = Skill::withCount(['registrations' => function ($q) {
            if ($this->selectedEdition !== 'all') {
                $q->where('edition_id', $this->selectedEdition);
            }
        }])
        ->orderByDesc('registrations_count')
        ->take(12)
        ->get();

        $recentRegistrations = (clone $baseQuery)
            ->with(['participant', 'skill', 'country', 'edition'])
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.admin.reports.index', [
            'totalUsers'            => User::count(),
            'totalRegistrations'    => $totalRegistrations,
            'approvedRegs'          => $approvedRegs,
            'qualifiedRegRegs'      => $qualifiedRegRegs,
            'qualifiedNatRegs'      => $qualifiedNatRegs,
            'pendingRegs'           => $pendingRegs,
            'rejectedRegs'          => $rejectedRegs,
            'totalSkills'           => Skill::count(),
            'totalWilayas'          => Wilaya::count(),
            'totalCountries'        => Country::count(),
            'totalOrgs'             => Organization::count(),
            'totalEditions'         => Edition::count(),
            'editionsList'          => Edition::orderByDesc('id')->get(),
            'topWilayas'            => $topWilayas,
            'topSkills'             => $topSkills,
            'recentRegistrations'   => $recentRegistrations,
        ]);
    }
}
