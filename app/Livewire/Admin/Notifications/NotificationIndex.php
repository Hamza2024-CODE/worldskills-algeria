<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\UserNotification;
use App\Models\WsapNotification;
use App\Services\Notifications\NotificationService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class NotificationIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';
    public string $filterPriority = '';
    public int    $perPage      = 10;
    public string $flashMessage = '';
    public string $flashMessageType = 'success';

    // Delete Confirmation
    public bool $showDeleteModal = false;
    public ?int $deletingId      = null;
    public string $deletingTitle = '';

    protected $queryString = ['search', 'filterType', 'filterStatus', 'filterPriority'];

    public function updatingSearch(): void         { $this->resetPage(); }
    public function updatingFilterType(): void     { $this->resetPage(); }
    public function updatingFilterStatus(): void   { $this->resetPage(); }
    public function updatingFilterPriority(): void { $this->resetPage(); }
    public function updatingPerPage(): void        { $this->resetPage(); }

    public function dispatchNow(int $id, NotificationService $service): void
    {
        $notification = WsapNotification::findOrFail($id);
        $res = $service->dispatchNotification($notification);
        $this->flashMessage = "تم إرسال التنبيه بنجاح إلى {$res['recipients_count']} مستخدماً معتمداً.";
        $this->flashMessageType = 'success';
    }

    public function cancelNotification(int $id, NotificationService $service): void
    {
        $notification = WsapNotification::findOrFail($id);
        $service->cancelNotification($notification);
        $this->flashMessage = "تم إلغاء الإشعار المجدول بنجاح.";
        $this->flashMessageType = 'warning';
    }

    public function confirmDelete(int $id, string $title): void
    {
        $this->deletingId = $id;
        $this->deletingTitle = $title;
        $this->showDeleteModal = true;
    }

    public function deleteNotification(): void
    {
        if ($this->deletingId) {
            WsapNotification::findOrFail($this->deletingId)->delete();
            $this->flashMessage = "تم حذف الإشعار بنجاح من قاعدة البيانات.";
            $this->flashMessageType = 'danger';
        }
        $this->showDeleteModal = false;
        $this->deletingId = null;
    }

    public function duplicateNotification(int $id): void
    {
        $n = WsapNotification::with('targets')->findOrFail($id);
        $new = $n->replicate(['uuid', 'status', 'dispatched_at', 'created_at', 'updated_at']);
        $new->status = 'DRAFT';
        $new->created_by = auth()->id();
        $new->save();

        foreach ($n->targets as $t) {
            $new->targets()->create([
                'target_type' => $t->target_type,
                'target_id'   => $t->target_id,
            ]);
        }

        $this->flashMessage = "تم تكرار الإشعار بنجاح لإنشاء مسودة جديدة.";
        $this->flashMessageType = 'success';
    }

    public function render(NotificationService $service)
    {
        $query = WsapNotification::with(['creator', 'targets', 'userNotifications'])
            ->when($this->search, function ($q) {
                $s = '%' . trim($this->search) . '%';
                $q->where('title_ar', 'like', $s)
                  ->orWhere('body_ar', 'like', $s)
                  ->orWhere('title_fr', 'like', $s)
                  ->orWhere('title_en', 'like', $s);
            })
            ->when($this->filterType, fn($q) => $q->where('type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterPriority, fn($q) => $q->where('priority', $this->filterPriority));

        $notifications = $query->orderByDesc('created_at')->paginate($this->perPage);

        // Analytics Map
        $analyticsMap = [];
        foreach ($notifications as $n) {
            $analyticsMap[$n->id] = $service->getDeliveryAnalytics($n);
        }

        // Global Analytics KPIs
        $totalCount     = WsapNotification::count();
        $sentCount      = WsapNotification::where('status', 'SENT')->count();
        $scheduledCount = WsapNotification::where('status', 'SCHEDULED')->count();
        $urgentCount    = WsapNotification::where('priority', 'URGENT')->count();
        $totalDelivered = UserNotification::whereNotNull('delivered_at')->count();
        $totalRead      = UserNotification::whereIn('status', ['READ', 'CLICKED'])->count();

        $overallReadRate = $totalDelivered > 0 ? round(($totalRead / $totalDelivered) * 100, 1) : 0;

        return view('livewire.admin.notifications.index', [
            'notifications'   => $notifications,
            'analyticsMap'    => $analyticsMap,
            'totalCount'      => $totalCount,
            'sentCount'       => $sentCount,
            'scheduledCount'  => $scheduledCount,
            'urgentCount'     => $urgentCount,
            'totalDelivered'  => $totalDelivered,
            'overallReadRate' => $overallReadRate,
        ]);
    }
}
