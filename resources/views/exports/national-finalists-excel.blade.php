<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="ProgId" content="Excel.Sheet" />
    <meta name="Generator" content="Microsoft Excel 15" />
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif; 
            direction: rtl; 
        }
        .title-republic { 
            font-size: 15pt; 
            font-weight: bold; 
            text-align: center; 
            color: #06205C; 
            height: 32px; 
            vertical-align: middle;
        }
        .title-ministry { 
            font-size: 13pt; 
            font-weight: bold; 
            text-align: center; 
            color: #1E293B; 
            height: 28px; 
            vertical-align: middle;
        }
        .title-event { 
            font-size: 14pt; 
            font-weight: bold; 
            text-align: center; 
            color: #0066FF; 
            height: 30px; 
            vertical-align: middle;
        }
        .title-doc { 
            font-size: 13pt; 
            font-weight: bold; 
            text-align: center; 
            color: #047857; 
            background-color: #ECFDF5; 
            height: 28px; 
            vertical-align: middle;
        }
        .meta-info { 
            font-size: 10pt; 
            font-weight: bold; 
            color: #475569; 
            background-color: #F1F5F9; 
            height: 25px; 
            border: 1px solid #CBD5E1;
            vertical-align: middle;
        }
        th { 
            background-color: #06205C; 
            color: #FFFFFF; 
            font-weight: bold; 
            font-size: 10.5pt; 
            border: 1px solid #94A3B8; 
            text-align: center; 
            vertical-align: middle;
            height: 34px;
        }
        td { 
            border: 1px solid #CBD5E1; 
            font-size: 10pt; 
            vertical-align: middle; 
            height: 26px;
            padding: 4px 6px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .bold { font-weight: bold; }
        .reg-no { font-family: 'Courier New', monospace; font-weight: bold; color: #0052CC; text-align: center; mso-number-format: "\@"; }
        .nin-text { font-family: 'Courier New', monospace; text-align: center; mso-number-format: "\@"; }
        .phone-text { font-family: 'Courier New', monospace; text-align: center; mso-number-format: "\@"; }
        .row-even { background-color: #F8FAFC; }
        .badge-qual { background-color: #D1FAE5; color: #065F46; font-weight: bold; text-align: center; }
        .female { color: #BE185D; font-weight: bold; text-align: center; }
        .male { color: #1D4ED8; font-weight: bold; text-align: center; }
    </style>
</head>
<body dir="rtl">
    <table border="1" style="border-collapse: collapse; width: 100%; direction: rtl;">
        <!-- Header State Letterhead -->
        <tr>
            <td colspan="17" class="title-republic">الجمهورية الجزائرية الديمقراطية الشعبية</td>
        </tr>
        <tr>
            <td colspan="17" class="title-ministry">وزارة التكوين والتعليم المهنيين</td>
        </tr>
        <tr>
            <td colspan="17" class="title-event">أولمبياد المهارات الجزائر 2026 — WorldSkills Algeria</td>
        </tr>
        <tr>
            <td colspan="17" class="title-doc">قائمة المتأهلين إلى الأولمبياد الوطنية حسب الولاية والمؤسسة التكوينية</td>
        </tr>
        <tr>
            <td colspan="4" class="meta-info text-right">نطاق الولاية: {{ $wilayaName }}</td>
            <td colspan="5" class="meta-info text-right">نطاق التخصص: {{ $skillName }}</td>
            <td colspan="4" class="meta-info text-center">تاريخ التصدير: {{ $generatedAt }}</td>
            <td colspan="4" class="meta-info text-left">إجمالي المتأهلين: {{ count($registrations) }} متنافس وطني</td>
        </tr>
        <tr>
            <td colspan="17" style="height: 14px; background-color: #FFFFFF; border: none;"></td>
        </tr>

        <!-- Table Columns -->
        <thead>
            <tr>
                <th style="width: 35px;">#</th>
                <th style="width: 140px;">رقم التسجيل الوطني</th>
                <th style="width: 170px;">الاسم واللقب (عربي)</th>
                <th style="width: 160px;">Nom & Prénom</th>
                <th style="width: 55px;">الجنس</th>
                <th style="width: 90px;">تاريخ الميلاد</th>
                <th style="width: 155px;">الرقم التعريفي الوطني (NIN)</th>
                <th style="width: 100px;">رقم الهاتف</th>
                <th style="width: 65px;">رمز الولاية</th>
                <th style="width: 110px;">الولاية</th>
                <th style="width: 230px;">المؤسسة التكوينية</th>
                <th style="width: 75px;">رمز المهارة</th>
                <th style="width: 190px;">التخصص والمهارة الرسمية</th>
                <th style="width: 70px;">مقاس البدلة</th>
                <th style="width: 70px;">مقاس الحذاء</th>
                <th style="width: 70px;">الطول (سم)</th>
                <th style="width: 130px;">حالة التأهيل</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $r)
                @php
                    $p = $r->participant;
                    $isFemale = in_array(strtolower($p?->gender ?? ''), ['female', 'أنثى']);
                    $rowClass = ($index % 2 === 1) ? 'row-even' : '';
                @endphp
                <tr class="{{ $rowClass }}">
                    <td class="text-center bold">{{ $index + 1 }}</td>
                    <td class="reg-no">{{ $r->registration_number }}</td>
                    <td class="text-right bold">{{ $p?->first_name_ar }} {{ $p?->last_name_ar }}</td>
                    <td class="text-left">{{ $p?->first_name_fr }} {{ $p?->last_name_fr }}</td>
                    <td class="{{ $isFemale ? 'female' : 'male' }}">
                        {{ $isFemale ? 'أنثى' : 'ذكر' }}
                    </td>
                    <td class="text-center">{{ $p?->date_of_birth ?? '—' }}</td>
                    <td class="nin-text">{{ $p?->national_id ?? '—' }}</td>
                    <td class="phone-text">{{ $p?->phone ?? '—' }}</td>
                    <td class="text-center bold">
                        {{ $p?->wilaya?->code ? sprintf('%02d', $p->wilaya->code) : '—' }}
                    </td>
                    <td class="text-right bold">{{ $p?->wilaya?->name_ar ?? '—' }}</td>
                    <td class="text-right">{{ $p?->organization?->name_ar ?? '—' }}</td>
                    <td class="text-center bold" style="color: #0066FF;">{{ $r->skill?->code ?? '—' }}</td>
                    <td class="text-right bold">{{ $r->skill?->getLocalized('name') ?? 'تخصص عام' }}</td>
                    <td class="text-center bold">{{ $r->suit_size ?? '—' }}</td>
                    <td class="text-center bold">{{ $r->shoe_size ?? '—' }}</td>
                    <td class="text-center">{{ $r->height_cm ?? '—' }}</td>
                    <td class="badge-qual">مؤهل للمسابقة الوطنية</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
