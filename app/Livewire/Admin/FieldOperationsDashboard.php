<?php

namespace App\Livewire\Admin;

use App\Models\AccessDecisionLog;
use App\Models\Country;
use App\Models\EmergencyLockdown;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\ParticipantProfile;
use App\Models\Restaurant;
use App\Models\ScheduleEvent;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\WsapNotification;
use App\Services\Emergency\EmergencyControlService;
use App\Services\Notifications\NotificationService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class FieldOperationsDashboard extends Component
{
    public string $activeTab = 'access_logs'; // 'access_logs', 'catering', 'events', 'emergency'
    public string $decisionFilter = 'ALL';    // 'ALL', 'ALLOW', 'DENY'
    public string $serviceFilter = 'ALL';     // 'ALL', 'CHECKPOINT', 'RESTAURANT', 'ZONE'

    // Emergency Lockdown Modal
    public bool   $showEmergencyModal = false;
    public string $lockdown_scope     = 'ZONE';
    public string $target_id          = '';
    public string $title_ar           = '';
    public string $reason_ar          = '';

    // Field Notification Modal
    public bool   $showNotificationModal = false;
    public string $notif_title_ar        = '';
    public string $notif_body_ar         = '';
    public string $notif_priority        = 'HIGH';

    public string $flashMessage          = '';

    public function setTab(string $tab): void
    {
        $validTabs = ['access_logs', 'catering', 'events', 'emergency'];
        if (in_array($tab, $validTabs, true)) {
            $this->activeTab = $tab;
        }
    }

    public function toggleMealSlot(int $slotId): void
    {
        $slot = MealSlot::find($slotId);
        if ($slot) {
            $slot->is_open = !$slot->is_open;
            $slot->save();
            $statusStr = $slot->is_open ? 'فتح' : 'إغلاق';
            $this->flashMessage = "تم {$statusStr} فترة الإطعام ({$slot->meal_type}) بنجاح.";
        }
    }

    public function initiateLockdown(EmergencyControlService $emergencyService): void
    {
        $this->validate([
            'lockdown_scope' => 'required|string',
            'title_ar'       => 'required|string|max:255',
            'reason_ar'      => 'required|string',
        ]);

        $emergencyService->initiateLockdown(
            $this->lockdown_scope,
            $this->target_id ?: null,
            $this->title_ar,
            $this->reason_ar
        );

        $this->flashMessage = "تم تفعيل وضع الإغلاق الأمني للطوارئ بنجاح.";
        $this->showEmergencyModal = false;
        $this->title_ar = '';
        $this->reason_ar = '';
        $this->target_id = '';
    }

    public function liftLockdown(int $lockdownId, EmergencyControlService $emergencyService): void
    {
        $lockdown = EmergencyLockdown::findOrFail($lockdownId);
        $emergencyService->liftLockdown($lockdown);
        $this->flashMessage = "تم رفع وضع الإغلاق الأمني للطوارئ.";
    }

    public function sendFieldAlert(NotificationService $notificationService): void
    {
        $this->validate([
            'notif_title_ar' => 'required|string|max:255',
            'notif_body_ar'  => 'required|string',
        ]);

        $allUserIds = User::where('is_active', true)->pluck('id')->toArray();

        $notificationData = [
            'type'       => 'EMERGENCY',
            'title_ar'   => $this->notif_title_ar,
            'title_fr'   => 'Alerte opérationnelle du terrain',
            'title_en'   => 'Operational Field Alert',
            'body_ar'    => $this->notif_body_ar,
            'priority'   => $this->notif_priority,
            'status'     => 'DRAFT',
            'created_by' => auth()->id() ?? 1,
        ];

        $targets = array_map(fn($id) => ['target_type' => 'USER', 'target_id' => (string) $id], array_slice($allUserIds, 0, 500));

        $notification = $notificationService->createNotification($notificationData, $targets);
        $notificationService->dispatchNotification($notification);

        $this->flashMessage = "تم تعميم وتوزيع التنبيه الميداني المباشر بنجاح.";
        $this->showNotificationModal = false;
        $this->notif_title_ar = '';
        $this->notif_body_ar = '';
    }

    public function render()
    {
        // 1. Live Access Logs Query
        $accessQuery = AccessDecisionLog::with(['badge.user', 'operator', 'zone']);

        if ($this->decisionFilter !== 'ALL') {
            $accessQuery->where('decision', $this->decisionFilter);
        }

        if ($this->serviceFilter !== 'ALL') {
            $accessQuery->where('service_type', $this->serviceFilter);
        }

        $recentDecisions = $accessQuery->latest('scanned_at')->take(25)->get();

        // 2. Metrics & Aggregates
        $totalDecisions = AccessDecisionLog::count();
        $allowedTotal   = AccessDecisionLog::where('decision', 'ALLOW')->count();
        $deniedTotal    = AccessDecisionLog::where('decision', 'DENY')->count();

        $todayAccesses  = AccessDecisionLog::whereDate('scanned_at', today())->get();
        $allowedToday   = $todayAccesses->where('decision', 'ALLOW')->count();
        $deniedToday    = $todayAccesses->where('decision', 'DENY')->count();

        $activeLockdowns = EmergencyLockdown::where('is_active', true)->get();
        $mealSlots       = MealSlot::with('restaurant')->get();
        $todayMealScans  = MealScan::whereDate('scanned_at', today())->count();
        $totalMealScans  = MealScan::count();

        $todayEvents = ScheduleEvent::whereDate('start_at', today())->get();
        if ($todayEvents->count() === 0) {
            $todayEvents = ScheduleEvent::orderBy('start_at', 'desc')->take(5)->get();
        }

        return view('livewire.admin.field-operations', [
            'totalUsers'          => User::count(),
            'totalParticipants'   => ParticipantProfile::count(),
            'totalCountries'      => Country::count(),
            'totalSkills'         => Skill::count(),
            'totalRestaurants'    => Restaurant::count(),
            'activeMealSlots'     => MealSlot::where('is_open', true)->count(),
            'mealSlots'           => $mealSlots,
            'todayMealScans'      => $todayMealScans,
            'totalMealScans'      => $totalMealScans,
            'totalDecisions'      => $totalDecisions,
            'allowedTotal'        => $allowedTotal,
            'deniedTotal'         => $deniedTotal,
            'allowedToday'        => $allowedToday,
            'deniedToday'         => $deniedToday,
            'recentDecisions'     => $recentDecisions,
            'activeLockdowns'     => $activeLockdowns,
            'todayEvents'         => $todayEvents,
            'totalNotifications'  => WsapNotification::count(),
            'deliveredCount'      => UserNotification::count(),
            'readCount'           => UserNotification::whereNotNull('read_at')->orWhere('status', 'READ')->count(),
            'flashMessage'        => $this->flashMessage,
            'activeTab'           => $this->activeTab,
            'decisionFilter'      => $this->decisionFilter,
            'serviceFilter'       => $this->serviceFilter,
            'showEmergencyModal'  => $this->showEmergencyModal,
            'showNotificationModal' => $this->showNotificationModal,
        ]);
    }
}
