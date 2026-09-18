<?php

namespace App\Livewire\Admin;

use App\Models\Registration;
use App\Models\Skill;
use App\Models\Wilaya;
use App\Models\WsapNotification;
use App\Services\Notifications\NotificationService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class ReadinessCenter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $readinessFilter = 'all'; // 'all', 'complete', 'incomplete', 'missing_nin', 'missing_sizes'
    public string $wilayaFilter = '';
    public string $skillFilter = '';
    public int $perPage = 15;

    public ?int $selectedRegistrationId = null;
    public bool $showDetailsModal = false;
    public string $actionFeedback = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'readinessFilter' => ['except' => 'all'],
        'wilayaFilter' => ['except' => ''],
        'skillFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingReadinessFilter()
    {
        $this->resetPage();
    }

    public function updatingWilayaFilter()
    {
        $this->resetPage();
    }

    public function updatingSkillFilter()
    {
        $this->resetPage();
    }

    public function viewCandidateDetails(int $registrationId): void
    {
        $this->selectedRegistrationId = $registrationId;
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedRegistrationId = null;
    }

    public function sendCandidateReminder(int $registrationId, NotificationService $notificationService): void
    {
        $reg = Registration::with(['participant', 'user'])->find($registrationId);
        if (!$reg) return;

        $userId = $reg->user?->id ?? $reg->participant?->user_id;
        if (!$userId) {
            $this->actionFeedback = 'تعذر العثور على حساب المستخدم للمترشح.';
            return;
        }

        $missing = $this->getMissingFieldsList($reg);
        $missingText = !empty($missing) ? implode('، ', $missing) : 'استكمال معلومات الملف الشخصي';

        $notificationData = [
            'type' => 'SYSTEM',
            'title_ar' => 'تذكير عاجل: استكمال بيانات الترشح لأولمبياد المهن 2026',
            'title_fr' => 'Rappel important: Compléter vos données de candidature',
            'title_en' => 'Important Reminder: Complete your candidate application data',
            'body_ar' => "عزيزي المترشح {$reg->participant?->first_name_ar}، يرجى استكمال البيانات التالية في ملفك: ({$missingText}).",
            'body_fr' => "Veuillez compléter les informations suivantes: ({$missingText}).",
            'priority' => 'HIGH',
            'status' => 'DRAFT',
            'created_by' => auth()->id() ?? 1,
        ];

        $targets = [
            ['target_type' => 'USER', 'target_id' => (string) $userId]
        ];

        $notification = $notificationService->createNotification($notificationData, $targets);
        $notificationService->dispatchNotification($notification);

        $this->actionFeedback = "تم إرسال تذكير استكمال البيانات للمترشح ({$reg->participant?->first_name_ar} {$reg->participant?->last_name_ar}) بنجاح.";
    }

    public function sendBulkReminders(NotificationService $notificationService): void
    {
        $incompleteRegs = Registration::where('status', 'APPROVED')
            ->where(function ($q) {
                $q->whereNull('suit_size')
                    ->orWhere('suit_size', '')
                    ->orWhereNull('shoe_size')
                    ->orWhere('shoe_size', '')
                    ->orWhereNull('height_cm')
                    ->orWhereHas('participant', fn($pq) => $pq->whereNull('national_id')->orWhere('national_id', ''));
            })
            ->with(['participant', 'user'])
            ->get();

        $sentCount = 0;
        foreach ($incompleteRegs as $reg) {
            $userId = $reg->user?->id ?? $reg->participant?->user_id;
            if (!$userId) continue;

            $missing = $this->getMissingFieldsList($reg);
            $missingText = !empty($missing) ? implode('، ', $missing) : 'بيانات الملابس والتعريف الوطني';

            $notificationData = [
                'type' => 'SYSTEM',
                'title_ar' => 'تذكير رسمي: استكمال القياسات وبيانات الترشح',
                'title_fr' => 'Rappel officiel: Compléter vos mensurations et données',
                'body_ar' => "يرجى الدخول إلى حسابك واستكمال البيانات التالية: ({$missingText}).",
                'priority' => 'HIGH',
                'status' => 'DRAFT',
                'created_by' => auth()->id() ?? 1,
            ];

            $targets = [
                ['target_type' => 'USER', 'target_id' => (string) $userId]
            ];

            $notification = $notificationService->createNotification($notificationData, $targets);
            $notificationService->dispatchNotification($notification);
            $sentCount++;
        }

        $this->actionFeedback = "تم إرسال تذكير جماعي لـ {$sentCount} مترشحاً غير مستوفين للبيانات بنجاح.";
    }

    private function getMissingFieldsList(Registration $reg): array
    {
        $p = $reg->participant;
        $missing = [];
        if (empty($p?->national_id)) $missing[] = 'رقم التعريف الوطني (NIN)';
        if (empty($reg->suit_size)) $missing[] = 'قياس البدلة';
        if (empty($reg->shoe_size)) $missing[] = 'قياس الحذاء';
        if (empty($reg->height_cm)) $missing[] = 'القامة';
        return $missing;
    }

    public function render()
    {
        // 1. KPI Counts
        $totalApprovedCount = Registration::where('status', 'APPROVED')->count();

        $missingNinCount = Registration::where('status', 'APPROVED')
            ->whereHas('participant', fn($q) => $q->whereNull('national_id')->orWhere('national_id', ''))
            ->count();

        $missingSizesCount = Registration::where('status', 'APPROVED')
            ->where(function ($q) {
                $q->whereNull('suit_size')
                    ->orWhere('suit_size', '')
                    ->orWhereNull('shoe_size')
                    ->orWhere('shoe_size', '')
                    ->orWhereNull('height_cm');
            })->count();

        $fullyCompleteCount = Registration::where('status', 'APPROVED')
            ->whereNotNull('suit_size')
            ->where('suit_size', '!=', '')
            ->whereNotNull('shoe_size')
            ->where('shoe_size', '!=', '')
            ->whereNotNull('height_cm')
            ->whereHas('participant', fn($q) => $q->whereNotNull('national_id')->where('national_id', '!=', ''))
            ->count();

        $incompleteCount = $totalApprovedCount - $fullyCompleteCount;
        $averageScore = $totalApprovedCount > 0 ? round(($fullyCompleteCount / $totalApprovedCount) * 100) : 0;

        // 2. Query Candidates List
        $query = Registration::with([
            'participant',
            'participant.wilaya',
            'participant.organization',
            'skill',
            'documents',
            'user'
        ])->where('status', 'APPROVED');

        // Filter: Readiness
        if ($this->readinessFilter === 'complete') {
            $query->whereNotNull('suit_size')
                ->where('suit_size', '!=', '')
                ->whereNotNull('shoe_size')
                ->where('shoe_size', '!=', '')
                ->whereNotNull('height_cm')
                ->whereHas('participant', fn($q) => $q->whereNotNull('national_id')->where('national_id', '!=', ''));
        } elseif ($this->readinessFilter === 'incomplete') {
            $query->where(function ($q) {
                $q->whereNull('suit_size')
                    ->orWhere('suit_size', '')
                    ->orWhereNull('shoe_size')
                    ->orWhere('shoe_size', '')
                    ->orWhereNull('height_cm')
                    ->orWhereHas('participant', fn($pq) => $pq->whereNull('national_id')->orWhere('national_id', ''));
            });
        } elseif ($this->readinessFilter === 'missing_nin') {
            $query->whereHas('participant', fn($q) => $q->whereNull('national_id')->orWhere('national_id', ''));
        } elseif ($this->readinessFilter === 'missing_sizes') {
            $query->where(function ($q) {
                $q->whereNull('suit_size')
                    ->orWhere('suit_size', '')
                    ->orWhereNull('shoe_size')
                    ->orWhere('shoe_size', '')
                    ->orWhereNull('height_cm');
            });
        }

        // Filter: Wilaya
        if (!empty($this->wilayaFilter)) {
            $query->whereHas('participant', fn($q) => $q->where('wilaya_id', $this->wilayaFilter));
        }

        // Filter: Skill
        if (!empty($this->skillFilter)) {
            $query->where('skill_id', $this->skillFilter);
        }

        // Search
        if (!empty($this->search)) {
            $term = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($term) {
                $q->where('registration_number', 'like', $term)
                    ->orWhereHas('participant', function ($pq) use ($term) {
                        $pq->where('first_name_ar', 'like', $term)
                            ->orWhere('last_name_ar', 'like', $term)
                            ->orWhere('first_name_fr', 'like', $term)
                            ->orWhere('last_name_fr', 'like', $term)
                            ->orWhere('national_id', 'like', $term)
                            ->orWhere('phone', 'like', $term);
                    });
            });
        }

        $candidates = $query->orderBy('id', 'desc')->paginate($this->perPage);

        // Selected candidate for modal view
        $selectedRegistration = null;
        if ($this->selectedRegistrationId && $this->showDetailsModal) {
            $selectedRegistration = Registration::with([
                'participant',
                'participant.wilaya',
                'participant.organization',
                'skill',
                'documents',
                'user'
            ])->find($this->selectedRegistrationId);
        }

        return view('livewire.admin.readiness-center', [
            'totalApprovedCount' => $totalApprovedCount,
            'fullyCompleteCount' => $fullyCompleteCount,
            'incompleteCount' => $incompleteCount,
            'missingSizesCount' => $missingSizesCount,
            'missingNinCount' => $missingNinCount,
            'averageScore' => $averageScore,
            'candidates' => $candidates,
            'wilayas' => Wilaya::orderBy('code')->get(),
            'skills' => Skill::orderBy('name_ar')->get(),
            'selectedRegistration' => $selectedRegistration,
        ]);
    }
}
