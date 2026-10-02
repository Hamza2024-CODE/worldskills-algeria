<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المتأهلين إلى الأولمبياد الوطنية 2026 - WorldSkills Algeria</title>
    <style>
        @page { size: A4 landscape; margin: 12mm 15mm; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, 'Cairo', sans-serif; 
            background: #fff; 
            color: #0f172a; 
            margin: 0; 
            padding: 15px; 
            direction: rtl; 
            font-size: 11px; 
            line-height: 1.4;
        }
        .header { 
            text-align: center; 
            border-bottom: 3px double #06205C; 
            padding-bottom: 12px; 
            margin-bottom: 15px; 
        }
        .republic { 
            font-size: 15px; 
            font-weight: 800; 
            color: #06205C; 
            margin: 2px 0; 
            letter-spacing: 0.5px;
        }
        .ministry { 
            font-size: 13px; 
            font-weight: 700; 
            color: #1e293b; 
            margin: 2px 0; 
        }
        .event-title { 
            font-size: 16px; 
            font-weight: 900; 
            color: #0066FF; 
            margin: 4px 0 2px 0; 
        }
        .doc-title { 
            font-size: 13px; 
            font-weight: 800; 
            color: #047857; 
            background: #ecfdf5;
            display: inline-block;
            padding: 4px 16px;
            border-radius: 20px;
            border: 1px solid #a7f3d0;
            margin-top: 4px;
        }
        .meta-bar { 
            display: flex; 
            justify-content: space-between; 
            background: #f8fafc; 
            padding: 8px 14px; 
            border-radius: 8px; 
            border: 1px solid #e2e8f0; 
            margin-bottom: 15px; 
            font-weight: 600; 
            font-size: 11px; 
        }
        .meta-bar span strong { color: #06205C; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        th, td { 
            border: 1px solid #cbd5e1; 
            padding: 6px 8px; 
            text-align: right; 
        }
        th { 
            background-color: #06205C; 
            color: #ffffff; 
            font-weight: 800; 
            font-size: 10.5px; 
            text-align: center;
        }
        tr:nth-child(even) { background-color: #f8fafc; }
        .badge { 
            padding: 2px 7px; 
            border-radius: 4px; 
            font-weight: 800; 
            font-size: 9.5px; 
            display: inline-block; 
            white-space: nowrap;
        }
        .badge-national { background-color: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .gender-f { color: #db2777; font-weight: bold; }
        .gender-m { color: #2563eb; font-weight: bold; }
        .footer { 
            margin-top: 25px; 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-end; 
            font-size: 10.5px; 
            color: #475569; 
            font-weight: bold; 
            page-break-inside: avoid;
        }
        .stamp-box { 
            border: 2px dashed #94a3b8; 
            padding: 25px 45px; 
            border-radius: 8px; 
            text-align: center; 
            min-width: 220px; 
            background: #fafafa;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="republic">الجمهورية الجزائرية الديمقراطية الشعبية</div>
        <div class="ministry">وزارة التكوين والتعليم المهنيين</div>
        <div class="event-title">أولمبياد المهارات الجزائر 2026 — WorldSkills Algeria</div>
        <div class="doc-title">قائمة المتأهلين إلى الأولمبياد الوطنية حسب الولاية والمؤسسة التكوينية</div>
    </div>

    <div class="meta-bar">
        <span>الولاية: <strong>{{ $wilayaName }}</strong></span>
        <span>المؤسسة: <strong>{{ $organizationName ?? 'كافة المؤسسات' }}</strong></span>
        <span>التخصص المهني: <strong>{{ $skillName }}</strong></span>
        <span>تاريخ التقرير: <strong>{{ $generatedAt }}</strong></span>
        <span>إجمالي المتأهلين: <strong style="color: #047857; font-size: 12px;">{{ count($registrations) }} متنافس</strong></span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 26px;">#</th>
                <th style="width: 120px;">رقم التسجيل</th>
                <th>اسم ولقب المترشح (عربي / فرنسي)</th>
                <th style="width: 45px;">الجنس</th>
                <th style="width: 130px;">رقم التعريف الوطني (NIN)</th>
                <th>الولاية</th>
                <th>المؤسسة التكوينية</th>
                <th>التخصص والمهارة الدولية</th>
                <th style="width: 75px;">المقاسات</th>
                <th style="width: 85px;">الهاتف</th>
                <th style="width: 85px;">حالة التأهيل</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $r)
                @php
                    $p = $r->participant;
                    $isFemale = in_array(strtolower($p?->gender ?? ''), ['female', 'أنثى']);
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold; color: #0066FF; text-align: center;">
                        {{ $r->registration_number }}
                    </td>
                    <td>
                        <strong style="color: #0f172a;">{{ $p?->first_name_ar }} {{ $p?->last_name_ar }}</strong>
                        @if($p?->first_name_fr)
                            <div style="font-size: 9.5px; color: #64748b; font-family: sans-serif;">{{ $p?->first_name_fr }} {{ $p?->last_name_fr }}</div>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($isFemale)
                            <span class="gender-f">أنثى</span>
                        @else
                            <span class="gender-m">ذكر</span>
                        @endif
                    </td>
                    <td style="font-family: monospace; font-size: 10px; text-align: center;">{{ $p?->national_id ?? '—' }}</td>
                    <td style="font-weight: 700;">{{ $p?->wilaya?->code ? sprintf('%02d', $p->wilaya->code) . ' - ' : '' }}{{ $p?->wilaya?->name_ar ?? '—' }}</td>
                    <td style="font-size: 9.5px;">{{ $p?->organization?->name_ar ?? '—' }}</td>
                    <td style="font-weight: 700; color: #1e3a8a;">
                        {{ $r->skill?->code ? '[' . $r->skill->code . '] ' : '' }}{{ $r->skill?->getLocalized('name') ?? 'تخصص عام' }}
                    </td>
                    <td style="font-size: 9.5px; text-align: center;">
                        بدلة: <strong>{{ $r->suit_size ?? '—' }}</strong><br>
                        حذاء: <strong>{{ $r->shoe_size ?? '—' }}</strong>
                    </td>
                    <td style="font-family: monospace; font-size: 10px; text-align: center; direction: ltr;">
                        {{ $p?->phone ?? '—' }}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge badge-national">مؤهل وطني</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center; color: #94a3b8; padding: 25px; font-size: 13px;">
                        لا توجد أي نتائج مطابقة للقائمة المحددة
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div>
            <p style="margin: 3px 0;">تم استخراج وطباعة هذا المستند الرسمي آلياً من المنصة المركزية لأولمبياد المهارات الجزائر 2026</p>
            <p style="margin: 3px 0; color: #0284c7; font-family: monospace;">WSAP-AUTH-ID: DZ-NAT-2026-{{ date('Ymd-His') }}</p>
        </div>
        <div class="stamp-box">
            <span style="display: block; margin-bottom: 8px;">توقيع وخاتم اللجنة الوطنية للتنظيم والتحكيم</span>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
