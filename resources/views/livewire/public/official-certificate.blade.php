<div class="min-h-screen bg-slate-900 flex flex-col items-center justify-center py-6 px-4 font-sans print:bg-white dark:bg-slate-900 print:p-0 print:m-0">
    
    <!-- Top Action Bar (Hidden when printing) -->
    <div class="w-full max-w-[297mm] mb-4 flex items-center justify-between text-white print:hidden">
        <a href="{{ route('admin.certificates') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-bold transition flex items-center gap-1.5 shadow-md">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>رجوع لمركز الشهادات</span>
        </a>

        <div class="flex items-center gap-3">
            <span class="text-xs font-mono bg-emerald-950 text-emerald-300 px-3 py-1.5 rounded-lg border border-emerald-800 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>وثيقة رسمية موثقة (WSAP V8.1 Verified)</span>
            </span>

            <button onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-lg shadow-amber-500/20 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة الشهادة الرسمية (Print A4 Certificate)</span>
            </button>
        </div>
    </div>

    <!-- PURE 100% FULL-BLEED A4 LANDSCAPE CERTIFICATE DOCUMENT -->
    <div class="certificate-document relative w-[297mm] h-[210mm] bg-white dark:bg-slate-900 overflow-hidden shadow-2xl print:shadow-none print:m-0 print:p-0 print:border-none print:w-[297mm] print:h-[210mm]">
        
        <!-- Untouched Official Background Layer -->
        <img src="{{ $background_url }}" alt="Official Background Certificate" class="absolute inset-0 w-full h-full object-fill pointer-events-none select-none z-0">

        <!-- DYNAMIC OVERLAY FIELDS (ZERO UI CHROME) -->

        <!-- Serial Code Badge -->
        <div class="absolute z-10 font-mono text-[11px] font-black text-slate-600 dark:text-slate-400 bg-white/80 dark:bg-slate-900/80 px-2.5 py-0.5 rounded border border-slate-300" style="top: {{ $fields['serial']['top_pct'] }}%; left: {{ $fields['serial']['left_pct'] }}%;">
            {{ $serial_number }}
        </div>

        <!-- Recipient Name Arabic (RTL) - Middle Red Zone -->
        <div class="absolute z-10 text-center font-black text-[#06205C] tracking-wide" style="top: {{ $fields['recipient_name_ar']['top_pct'] }}%; left: {{ $fields['recipient_name_ar']['left_pct'] ?? 35 }}%; width: {{ $fields['recipient_name_ar']['width_pct'] ?? 32 }}%; font-size: {{ $fields['recipient_name_ar']['font_size'] }}; direction: rtl; text-align: {{ $fields['recipient_name_ar']['align'] ?? 'center' }};">
            {{ $recipient_name_ar }}
        </div>

        <!-- Recipient Name Latin / English (LTR) - Middle Red Zone -->
        <div class="absolute z-10 text-center font-bold font-mono text-sky-700 tracking-wider uppercase" style="top: {{ $fields['recipient_name_latin']['top_pct'] }}%; left: {{ $fields['recipient_name_latin']['left_pct'] ?? 35 }}%; width: {{ $fields['recipient_name_latin']['width_pct'] ?? 32 }}%; font-size: {{ $fields['recipient_name_latin']['font_size'] }}; direction: ltr; text-align: {{ $fields['recipient_name_latin']['align'] ?? 'center' }};">
            {{ $recipient_name_latin }}
        </div>

        <!-- Official Date -->
        <div class="absolute z-10 font-black text-[#06205C] font-mono" style="top: {{ $fields['date']['top_pct'] }}%; right: {{ $fields['date']['right_pct'] }}%; font-size: {{ $fields['date']['font_size'] }}; direction: rtl;">
            {{ $date_formatted }}
        </div>

        <!-- Secure Verification QR Code -->
        <div class="absolute z-10 bg-white dark:bg-slate-900 p-1 rounded-lg border border-slate-900 shadow-sm flex items-center justify-center" style="top: {{ $fields['qr']['top_pct'] }}%; left: {{ $fields['qr']['left_pct'] }}%; width: {{ $fields['qr']['size_px'] }}px; height: {{ $fields['qr']['size_px'] }}px;">
            <a href="{{ $verify_url }}" target="_blank" class="block w-full h-full">
                <img src="{{ $qr_code_url }}" alt="Verification QR Code" class="w-full h-full object-contain">
            </a>
        </div>

    </div>

</div>

<!-- CSS A4 LANDSCAPE PRINT RULES -->
<style>
@page {
    size: A4 landscape;
    margin: 0 !important;
}

@media print {
    /* Hide ALL site navigation headers, footers, and app shell chrome */
    header, nav, footer, .app-header, [role="navigation"], nav.bg-white dark:bg-slate-900, .print\:hidden {
        display: none !important;
        visibility: hidden !important;
        height: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    html, body {
        width: 297mm !important;
        height: 210mm !important;
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        overflow: hidden !important;
    }

    .min-h-screen {
        min-height: 0 !important;
        height: 210mm !important;
        padding: 0 !important;
        margin: 0 !important;
        background: white !important;
    }

    .certificate-document {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 297mm !important;
        height: 210mm !important;
        box-shadow: none !important;
        border: none !important;
        margin: 0 !important;
        padding: 0 !important;
        page-break-after: always;
        page-break-inside: avoid;
        z-index: 99999 !important;
    }
}
</style>
