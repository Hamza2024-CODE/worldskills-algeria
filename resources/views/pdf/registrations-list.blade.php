<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المترشحين والمشاركين - WorldSkills Algeria 2026</title>
    <style>
        @page { size: A4 landscape; margin: 15mm; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #fff; color: #1e293b; margin: 0; padding: 20px; direction: rtl; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #06205C; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { margin: 5px 0; font-size: 20px; color: #06205C; }
        .header h2 { margin: 3px 0; font-size: 14px; color: #475569; font-weight: 600; }
        .header p { margin: 3px 0; font-size: 11px; color: #64748b; }
        .meta-bar { display: flex; justify-content: space-between; background: #f8fafc; padding: 10px 15px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px; font-weight: bold; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: right; }
        th { background-color: #06205C; color: #ffffff; font-weight: bold; font-size: 11px; }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 10px; display: inline-block; }
        .badge-approved { background-color: #d1fae5; color: #065f46; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-rejected { background-color: #ffe4e6; color: #9f1239; }
        .footer { margin-top: 30px; display: flex; justify-content: space-between; font-size: 11px; color: #64748b; font-weight: bold; }
        .stamp-box { border: 2px dashed #cbd5e1; padding: 20px 40px; border-radius: 8px; text-align: center; min-width: 180px; }
    </style>
</head>
<body>

    <div class="header">
        <h2>الجمهورية الجزائرية الديمقراطية الشعبية</h2>
        <h2>وزارة التكوين والتعليم المهنيين</h2>
        <h1>أولمبياد المهن الوطنية - WorldSkills Algeria 2026</h1>
        <p>التقرير الرسمي لقائمة المشاركين والمترشحين المسجلين بالمجموعات</p>
    </div>

    <div class="meta-bar">
        <span>الولاية: <strong>{{ $wilayaName }}</strong></span>
        <span>الدولة: <strong>{{ $countryName }}</strong></span>
        <span>التخصص: <strong>{{ $skillName }}</strong></span>
        <span>تاريخ التقرير: <strong>{{ $generatedAt }}</strong></span>
        <span>إجمالي القائمة: <strong>{{ count($registrations) }} مشارك</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">#</th>
                <th>رقم التسجيل</th>
                <th>الاسم واللقب (عربي / فرنسي)</th>
                <th>رقم NIN</th>
                <th>التخصص والمهارة</th>
                <th>الولاية / الدولة</th>
                <th>المؤسسة التكوينية</th>
                <th>القياسات</th>
                <th style="text-align: center;">الحالة</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $r)
                @php
                    $p = $r->participant;
                    $statusVal = $r->status instanceof \App\Enums\ParticipantStatus ? $r->status->value : $r->status;
                    $badgeClass = match($statusVal) {
                        'APPROVED' => 'badge-approved',
                        'REJECTED' => 'badge-rejected',
                        default => 'badge-pending',
                    };
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold; color: #0066FF;">{{ $r->registration_number }}</td>
                    <td>
                        <strong>{{ $p?->first_name_ar }} {{ $p?->last_name_ar }}</strong>
                        @if($p?->first_name_fr)
                            <div style="font-size: 10px; color: #64748b;">{{ $p?->first_name_fr }} {{ $p?->last_name_fr }}</div>
                        @endif
                    </td>
                    <td style="font-family: monospace;">{{ $p?->national_id ?? '—' }}</td>
                    <td>{{ $r->skill?->getLocalized('name') ?? 'تخصص عام' }}</td>
                    <td>{{ $p?->wilaya?->name_ar ?? $r->country?->name_ar ?? 'الجزائر' }}</td>
                    <td style="font-size: 10px;">{{ $p?->organization?->name_ar ?? '—' }}</td>
                    <td style="font-size: 10px;">
                        بدلة: <strong>{{ $r->suit_size ?? '—' }}</strong> | حذاء: <strong>{{ $r->shoe_size ?? '—' }}</strong>
                    </td>
                    <td style="text-align: center;">
                        <span class="badge {{ $badgeClass }}">{{ $statusVal }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #94a3b8; padding: 20px;">لا توجد أي نتائج مطابقة للقائمة المحددة</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>
            <p>تم استخراج القائمة آلياً من منصة أولمبياد المهن WorldSkills Algeria 2026</p>
            <p>رمز التوثيق المصادق عليه: WSAP-PDF-{{ date('Ymd-His') }}</p>
        </div>
        <div class="stamp-box">
            <span>توقيع وختم اللجنة المنظمة</span>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
