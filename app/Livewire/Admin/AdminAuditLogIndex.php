<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminAuditLogIndex extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterEvent = '';
    public string $dateFrom    = '';
    public string $dateTo      = '';

    // Drawer
    public bool      $drawerOpen  = false;
    public ?AuditLog $selectedLog = null;

    protected $queryString = ['search', 'filterEvent'];

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFilterEvent(): void { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->search      = '';
        $this->filterEvent = '';
        $this->dateFrom    = '';
        $this->dateTo      = '';
        $this->resetPage();
    }

    public function openDrawer(int $id): void
    {
        $this->selectedLog = AuditLog::with('user')->find($id);
        $this->drawerOpen  = true;
    }

    public function exportCsv()
    {
        $query = AuditLog::with('user')
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('event', 'like', '%'.$this->search.'%')
                       ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                       ->orWhere('subject_type', 'like', '%'.$this->search.'%')
                       ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
                });
            })
            ->when($this->filterEvent, fn($q) => $q->where('event', $this->filterEvent))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest();

        $logs = $query->get();
        $filename = 'worldskills_audit_logs_' . date('Y_m_d_H_i') . '.csv';

        return response()->streamDownload(function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['--- سجلات التفتيش والتدقيق الأمني لمهارات الجزائر (WorldSkills Algeria Audit Logs) ---']);
            fputcsv($handle, ['تاريخ التصدير', date('Y-m-d H:i:s')]);
            fputcsv($handle, []);
            fputcsv($handle, ['# السجل', 'الحدث / العملية', 'المستخدم', 'عنوان IP', 'نوع الهدف (Subject)', 'معرف الهدف', 'تاريخ ووقت العملية']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->id,
                    $log->event,
                    $log->user?->name ?? 'زائر / نظام تلقائي',
                    $log->ip_address ?? 'N/A',
                    $log->subject_type ?? '—',
                    $log->subject_id ?? '—',
                    $log->created_at ? $log->created_at->format('Y-m-d H:i:s') : '—',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function render()
    {
        $query = AuditLog::with('user')
            ->when($this->search, function ($q) {
                $q->where(function ($sq) {
                    $sq->where('event', 'like', '%'.$this->search.'%')
                       ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                       ->orWhere('subject_type', 'like', '%'.$this->search.'%')
                       ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
                });
            })
            ->when($this->filterEvent, fn($q) => $q->where('event', $this->filterEvent))
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo))
            ->latest();

        return view('livewire.admin.audit.index', [
            'logs'          => $query->paginate(20),
            'totalLogs'     => AuditLog::count(),
            'allowCount'    => AuditLog::where('event', 'ACCESS_ALLOW')->count(),
            'denyCount'     => AuditLog::where('event', 'ACCESS_DENY')->count(),
            'overrideCount' => AuditLog::where('event', 'LIKE', '%OVERRIDE%')->count(),
            'settingCount'  => AuditLog::where('event', 'LIKE', '%SETTING%')->count(),
            'todayCount'    => AuditLog::whereDate('created_at', date('Y-m-d'))->count(),
            'events'        => AuditLog::select('event')->distinct()->pluck('event'),
        ]);
    }
}
