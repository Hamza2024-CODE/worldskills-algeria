<?php

namespace App\Enums;

enum ParticipantStatus: string
{
    case DRAFT = 'DRAFT';
    case SUBMITTED = 'SUBMITTED';
    case PENDING = 'PENDING';
    case UNDER_REVIEW = 'UNDER_REVIEW';
    case MISSING_DOCUMENTS = 'MISSING_DOCUMENTS';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case QUALIFIED = 'QUALIFIED';
    case QUALIFIED_REGIONAL = 'QUALIFIED_REGIONAL';
    case QUALIFIED_NATIONAL = 'QUALIFIED_NATIONAL';
    case DISQUALIFIED = 'DISQUALIFIED';
    case WITHDRAWN = 'WITHDRAWN';
    case COMPLETED = 'COMPLETED';

    public function label(): string
    {
        return match($this) {
            self::DRAFT => 'مسودة',
            self::SUBMITTED => 'تم الإرسال',
            self::PENDING => 'قيد التثبت',
            self::UNDER_REVIEW => 'قيد المراجعة',
            self::MISSING_DOCUMENTS => 'وثائق ناقصة',
            self::APPROVED => 'مقبول',
            self::REJECTED => 'مرفوض',
            self::QUALIFIED => 'متأهل',
            self::QUALIFIED_REGIONAL => 'مؤهل للبطولة الجهوية',
            self::QUALIFIED_NATIONAL => 'مؤهل للبطولة الوطنية',
            self::DISQUALIFIED => 'مستبعد',
            self::WITHDRAWN => 'منسحب',
            self::COMPLETED => 'مكتمل',
        };
    }
}
