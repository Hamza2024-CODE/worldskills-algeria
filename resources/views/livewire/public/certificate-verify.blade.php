<div class="min-h-screen bg-[#F4F7FC] flex items-center justify-center p-4 sm:p-8">
    <div class="w-full max-w-xl">

        @if($verifyStatus === 'VALID')
            {{-- VALID CERTIFICATE --}}
            <div class="bg-white rounded-3xl border-2 border-emerald-200 shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 px-8 py-8 text-white text-center">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <h1 class="text-2xl font-black leading-tight flex items-center justify-center gap-2 text-emerald-600"><x-ws.icon name="check-circle" class="w-7 h-7 shrink-0" /> الشهادة موثقة وصالحة</h1>
                    <p class="text-emerald-100 text-sm mt-1">CERTIFICATE VERIFIED — OFFICIAL WSAP VALIDATION</p>
                </div>

                <div class="px-8 py-7 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">صاحب الشهادة</div>
                            <div class="font-black text-slate-900">{{ $certificate->user?->name ?? '—' }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">نوع الشهادة</div>
                            <div class="font-black text-slate-900 text-sm">{{ $certificate->certificate_type }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">التخصص</div>
                            <div class="font-bold text-slate-900">{{ $certificate->skill?->name_ar ?? '—' }}</div>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">تاريخ الإصدار</div>
                            <div class="font-bold text-slate-900 font-mono text-sm">{{ $certificate->issued_at?->format('Y-m-d') }}</div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">معرف الشهادة (UUID)</div>
                        <div class="font-mono text-xs text-slate-600 break-all">{{ $certificate->certificate_uuid }}</div>
                    </div>
                </div>

                <div class="px-8 pb-7 text-center">
                    <div class="flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
                        <img src="/logo.svg" alt="WSAP" class="h-5 w-auto opacity-40">
                        <span>التحقق الرسمي — WorldSkills Algeria (WSAP V8.2)</span>
                    </div>
                </div>
            </div>

        @elseif($verifyStatus === 'REVOKED')
            <div class="bg-white rounded-3xl border-2 border-red-200 shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-br from-red-600 to-red-700 px-8 py-8 text-white text-center">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h1 class="text-2xl font-black flex items-center justify-center gap-2 text-rose-600"><x-ws.icon name="x-circle" class="w-7 h-7 shrink-0" /> الشهادة ملغاة</h1>
                    <p class="text-red-100 text-sm mt-1">CERTIFICATE REVOKED — INVALID</p>
                </div>
                <div class="px-8 py-7 text-center">
                    <p class="text-slate-700 font-bold">هذه الشهادة تم إلغاؤها من قبل الجهة المصدرة.</p>
                    @if($certificate?->revocation_reason)
                        <p class="text-sm text-slate-500 mt-2">السبب: {{ $certificate->revocation_reason }}</p>
                    @endif
                </div>
            </div>

        @elseif($verifyStatus === 'EXPIRED')
            <div class="bg-white rounded-3xl border-2 border-amber-200 shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-br from-amber-500 to-amber-600 px-8 py-8 text-white text-center">
                    <h1 class="text-2xl font-black flex items-center justify-center gap-2 text-amber-600"><x-ws.icon name="exclamation-triangle" class="w-7 h-7 shrink-0" /> الشهادة منتهية الصلاحية</h1>
                    <p class="text-amber-100 text-sm mt-1">CERTIFICATE EXPIRED</p>
                </div>
            </div>

        @else
            <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-br from-slate-700 to-slate-900 px-8 py-8 text-white text-center">
                    <h1 class="text-2xl font-black flex items-center justify-center gap-2 text-rose-600"><x-ws.icon name="x-circle" class="w-7 h-7 shrink-0" /> الشهادة غير موجودة</h1>
                    <p class="text-slate-300 text-sm mt-1">CERTIFICATE NOT FOUND — INVALID TOKEN</p>
                </div>
                <div class="px-8 py-7 text-center">
                    <p class="text-slate-600 font-bold text-sm">رمز التحقق المُدخل غير صالح أو لا يوجد في قاعدة البيانات.</p>
                </div>
            </div>
        @endif

    </div>
</div>
