<?php

namespace App\Livewire\Admin\Notifications;

use App\Models\Country;
use App\Models\MealSlot;
use App\Models\Skill;
use App\Models\User;
use App\Services\Notifications\NotificationService;
use App\Services\Notifications\NotificationTargetResolver;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class NotificationCreate extends Component
{
    // Form fields
    public string $type        = 'GENERAL';
    public string $priority    = 'NORMAL';
    public string $title_ar    = '';
    public string $title_fr    = '';
    public string $title_en    = '';
    public string $body_ar     = '';
    public string $body_fr     = '';
    public string $body_en     = '';

    public string $action_type = '';
    public string $action_id   = '';

    public string $scheduled_at= '';
    public string $expires_at  = '';

    // Audience Builder targets
    public array  $targetRoles       = [];
    public array  $targetCountries   = [];
    public array  $targetSkills      = [];
    public int    $targetMealSlot    = 0;
    public array  $targetUserIds     = [];

    // Live estimated recipients
    public int $estimatedRecipients = 0;

    protected array $rules = [
        'type'     => 'required|string',
        'priority' => 'required|in:LOW,NORMAL,HIGH,URGENT',
        'title_ar' => 'required|string|max:255',
        'body_ar'  => 'required|string',
    ];

    public function updated($propertyName)
    {
        $this->recalculateEstimatedRecipients();
    }

    public function applyTemplate(string $templateKey): void
    {
        switch ($templateKey) {
            case 'MEAL':
                $this->type = 'MEAL';
                $this->title_ar = 'وجبة الغداء متاحة الآن';
                $this->title_fr = 'Le déjeuner est disponible';
                $this->title_en = 'Lunch is now open';
                $this->body_ar = 'تذكرة: وجبة الغداء متاحة الآن في المطعم المخصص. يرجى إبراز الشارة الرسمية عند الدخول.';
                $this->priority = 'NORMAL';
                $this->action_type = 'MEAL_SLOT';
                break;

            case 'TECHNICAL_MEETING':
                $this->type = 'TECHNICAL_MEETING';
                $this->title_ar = 'تذكير باجتماع تقني جديد';
                $this->title_fr = 'Rappel de réunion technique';
                $this->title_en = 'Technical Meeting Reminder';
                $this->body_ar = 'نذكركم بحضور الاجتماع التقني الخاص بالتخصص لمناقشة التعليمات وقواعد التحكيم والتوزيع.';
                $this->priority = 'HIGH';
                $this->action_type = 'TECHNICAL_MEETING';
                break;

            case 'ACCOMMODATION':
                $this->type = 'ACCOMMODATION';
                $this->title_ar = 'تعليمات وتوزيع السكن والإقامة';
                $this->title_fr = 'Consignes d\'hébergement';
                $this->title_en = 'Accommodation Instructions';
                $this->body_ar = 'يرجى الاطلاع على تفاصيل الغرفة المسندة ومواعيد الدخول والمغادرة في مقر السكن.';
                $this->priority = 'NORMAL';
                $this->action_type = 'ACCOMMODATION';
                break;

            case 'URGENT':
                $this->type = 'URGENT';
                $this->priority = 'URGENT';
                $this->title_ar = 'تنبيه عاجل من الإدارة العليا';
                $this->title_fr = 'Alerte urgente de la direction';
                $this->title_en = 'Urgent Alert from Management';
                $this->body_ar = 'تنبيه هام وعاجل لجميع الأعضاء والوفود: يرجى الاتباع الفوري للتعليمات المرفقة.';
                $this->action_type = 'NOTIFICATION_CENTER';
                break;

            case 'COMPETITION':
                $this->type = 'COMPETITION';
                $this->title_ar = 'انطلاق الجولة القادمة للمنافسة';
                $this->title_fr = 'Début de la prochaine épreuve';
                $this->title_en = 'Start of Next Competition Round';
                $this->body_ar = 'نحيطكم علماً ببدء الجولة التنافسية القادمة. يرجى التواجد في الورشات 15 دقيقة قبل الانطلاق.';
                $this->priority = 'HIGH';
                $this->action_type = 'COMPETITION';
                break;
        }

        $this->recalculateEstimatedRecipients();
    }

    public function recalculateEstimatedRecipients(): void
    {
        $resolver = new NotificationTargetResolver();
        $targets = $this->buildTargetsArray();

        if (empty($targets)) {
            // Default to all active users if no filters picked
            $this->estimatedRecipients = User::where('is_active', true)->count();
        } else {
            $userIds = $resolver->resolveUserIds($targets);
            $this->estimatedRecipients = count($userIds);
        }
    }

    private function buildTargetsArray(): array
    {
        $targets = [];

        foreach ($this->targetRoles as $role) {
            $targets[] = ['target_type' => 'role', 'target_id' => $role];
        }

        foreach ($this->targetCountries as $cId) {
            $targets[] = ['target_type' => 'country', 'target_id' => (string) $cId];
        }

        foreach ($this->targetSkills as $sId) {
            $targets[] = ['target_type' => 'skill', 'target_id' => (string) $sId];
        }

        if ($this->targetMealSlot > 0) {
            $targets[] = ['target_type' => 'meal_slot', 'target_id' => (string) $this->targetMealSlot];
        }

        foreach ($this->targetUserIds as $uId) {
            $targets[] = ['target_type' => 'individual_user', 'target_id' => (string) $uId];
        }

        return $targets;
    }

    public function saveAndDispatch(NotificationService $service)
    {
        $this->validate();

        $targets = $this->buildTargetsArray();
        if (empty($targets)) {
            // If empty, target ALL roles
            foreach (['PARTICIPANT', 'COUNTRY_ADMIN', 'JUDGE', 'MEDIA_MANAGER', 'EXECUTIVE_VIEWER', 'ORGANIZATION_ADMIN', 'SUPER_ADMIN'] as $r) {
                $targets[] = ['target_type' => 'role', 'target_id' => $r];
            }
        }

        $notification = $service->createNotification([
            'type'         => $this->type,
            'priority'     => $this->priority,
            'title_ar'     => $this->title_ar,
            'title_fr'     => $this->title_fr,
            'title_en'     => $this->title_en,
            'body_ar'      => $this->body_ar,
            'body_fr'      => $this->body_fr,
            'body_en'      => $this->body_en,
            'action_type'  => $this->action_type,
            'action_id'    => $this->action_id,
            'scheduled_at' => $this->scheduled_at ?: null,
            'expires_at'   => $this->expires_at ?: null,
            'status'       => $this->scheduled_at ? 'SCHEDULED' : 'DRAFT',
            'created_by'   => auth()->id(),
        ], $targets);

        if (!$this->scheduled_at) {
            $service->dispatchNotification($notification);
            session()->flash('success', 'تم إرسال التنبيه فوراً لجميع المستهدفين.');
        } else {
            session()->flash('success', 'تم جدولة التنبيه بنجاح للوقت المحدد.');
        }

        return redirect()->route('admin.notifications.index');
    }

    public function mount()
    {
        $this->recalculateEstimatedRecipients();
    }

    public function render()
    {
        return view('livewire.admin.notifications.create', [
            'countries' => Country::orderBy('name_ar')->get(),
            'skills'    => Skill::orderBy('name_ar')->get(),
            'mealSlots' => MealSlot::with('restaurant')->orderByDesc('date')->take(15)->get(),
            'allUsers'  => User::orderBy('name')->get(),
        ]);
    }
}
