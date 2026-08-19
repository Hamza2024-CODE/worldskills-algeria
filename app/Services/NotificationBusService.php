<?php

namespace App\Services;

use App\Models\AppNotification;

/**
 * NotificationBusService
 *
 * Event-driven notification bus for the WSAP platform.
 * Centralizes all notification dispatch, ensuring consistent format and audit trail.
 */
class NotificationBusService
{
    /** Dispatch a typed notification to a specific user. */
    public function dispatch(
        int    $userId,
        string $type,
        string $titleAr,
        string $messageAr,
        string $severity = 'INFO',
        string $actionUrl = ''
    ): AppNotification {
        return AppNotification::create([
            'user_id'    => $userId,
            'type'       => $type,
            'title_ar'   => $titleAr,
            'message_ar' => $messageAr,
            'severity'   => $severity,
            'action_url' => $actionUrl,
        ]);
    }

    /** Notify upon registration approval. */
    public function registrationApproved(int $userId, string $registrationNumber): void
    {
        $this->dispatch(
            $userId,
            'REGISTRATION_APPROVED',
            'تم قبول طلب تسجيلك',
            "تم قبول طلب التسجيل رقم [{$registrationNumber}] بنجاح. يمكنك الاطلاع على تفاصيل ملفك من لوحتك الشخصية.",
            'SUCCESS',
            '/participant/dashboard'
        );
    }

    /** Notify upon registration rejection. */
    public function registrationRejected(int $userId, string $registrationNumber, string $reason): void
    {
        $this->dispatch(
            $userId,
            'REGISTRATION_REJECTED',
            'تم رفض طلب تسجيلك',
            "للأسف، تم رفض الطلب رقم [{$registrationNumber}]. السبب: {$reason}",
            'DANGER',
            '/participant/dashboard'
        );
    }

    /** Notify judge upon assignment. */
    public function judgeAssigned(int $judgeUserId, string $skillName): void
    {
        $this->dispatch(
            $judgeUserId,
            'JUDGE_ASSIGNED',
            'تم تكليفك بمهمة تحكيم',
            "تم تعيينك محكماً رسمياً في تخصص [{$skillName}]. يمكنك الوصول إلى نظام التقييم من لوحتك.",
            'INFO',
            '/hamza/cis'
        );
    }

    /** Notify when a score is locked by Chief Expert. */
    public function scoreLocked(int $userId, string $moduleName): void
    {
        $this->dispatch(
            $userId,
            'SCORE_LOCKED',
            'تم اعتماد وقفل التقييم',
            "تم قفل واعتماد تقييم وحدة [{$moduleName}] من قبل رئيس لجنة الخبراء.",
            'SUCCESS'
        );
    }

    /** Notify when a certificate is issued. */
    public function certificateIssued(int $userId, string $certType, string $verifyUrl): void
    {
        $this->dispatch(
            $userId,
            'CERTIFICATE_ISSUED',
            'صدرت شهادتك الرسمية',
            "صدرت شهادتك الرسمية من نوع [{$certType}]. يمكنك التحقق منها وتحميلها عبر الرابط المخصص.",
            'SUCCESS',
            $verifyUrl
        );
    }

    /** Notify when an appeal decision is issued. */
    public function appealDecisionIssued(int $userId, string $decision, string $appealUuid): void
    {
        $this->dispatch(
            $userId,
            'APPEAL_DECISION',
            'صدر قرار الطعن الفني',
            "صدر قرار اللجنة بشأن الطعن [{$appealUuid}]: {$decision}.",
            $decision === 'UPHELD' ? 'SUCCESS' : 'WARNING',
            '/hamza/appeals'
        );
    }

    /** Get unread count for a user. */
    public function unreadCount(int $userId): int
    {
        return AppNotification::where('user_id', $userId)->whereNull('read_at')->count();
    }

    /** Mark all notifications as read for a user. */
    public function markAllRead(int $userId): void
    {
        AppNotification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }
}
