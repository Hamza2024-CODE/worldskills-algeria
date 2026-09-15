<div class="space-y-6 pb-12">

    {{-- HEADER BANNER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#06205C] text-white p-6 rounded-3xl shadow-xl relative overflow-hidden">
        <div class="space-y-1 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-black tracking-wider uppercase border border-emerald-400/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>WSAP V8.4 — SUPER ADMIN COMMAND CENTER</span>
            </div>
            <h1 class="text-2xl font-black text-white">لوحة القيادة والإدارة العليا للمنصة (Super Admin Dashboard)</h1>
            <p class="text-xs text-blue-100/80 font-medium">
                المنظومة المركزية لإدارة وتأطير أولمبياد المهن الجزائرية، الوفود الوطنية، والتخصصات الأولمبية.
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('admin.operations') }}" class="px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs transition shadow-lg flex items-center gap-2 border border-emerald-400/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="flex items-center gap-1.5"><x-ws.icon name="cpu-chip" class="w-4 h-4 text-emerald-500" /> غرفة العمليات الميدانية المباشرة</span>
            </a>
        </div>
    </div>

    {{-- SYSTEM KPIs GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">إجمالي الحسابات المسجلة</div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalUsers) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">التسجيلات المعتمدة</div>
                <div class="text-2xl font-black text-emerald-600">{{ number_format($approvedRegistrations) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">الوفود والدول المشاركة</div>
                <div class="text-2xl font-black text-slate-900">{{ number_format($totalCountries) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">التخصصات الأولمبية</div>
                <div class="text-2xl font-black text-amber-600">{{ number_format($totalSkills) }}</div>
            </div>
        </div>
    </div>

    {{-- QUICK OPERATIONAL MODULES CARDS --}}
    <div class="space-y-3">
        <h3 class="text-base font-black text-[#06205C]">الوحدات والأنظمة التشغيلية السريعة</h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-bold">
            <a href="{{ route('admin.operations') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="cpu-chip" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">غرفة العمليات الميدانية</h4>
                    <p class="text-[11px] text-slate-500">بث حي لعمليات المسح، المطاعم، السكن والنقل.</p>
                </div>
            </a>

            <a href="{{ route('admin.schedule.index') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="calendar" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">محرك الجدولة الميداني</h4>
                    <p class="text-[11px] text-slate-500">إدارة تقويم الأحداث، الجولات والاجتماعات.</p>
                </div>
            </a>

            <a href="{{ route('admin.notifications.index') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="bell" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">مركز التواصل والتنبيهات</h4>
                    <p class="text-[11px] text-slate-500">إرسال التنبيهات الموجهة وتحليلات التسليم.</p>
                </div>
            </a>

            <a href="{{ route('admin.scanner') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="magnifying-glass" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">الماسح الموحد للشارات</h4>
                    <p class="text-[11px] text-slate-500">فحص وتفكيك الـ QR لجميع كواد المنصة.</p>
                </div>
            </a>

            <a href="{{ route('admin.accreditations') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="qr-code" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">مركز الاعتمادات والشارات</h4>
                    <p class="text-[11px] text-slate-500">تصميم وطباعة الشارات PVC الفردية والجماعية.</p>
                </div>
            </a>

            <a href="{{ route('admin.restaurants') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <x-ws.icon name="sparkles" class="w-5 h-5" />
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">إدارة المطاعم واللوجستيك</h4>
                    <p class="text-[11px] text-slate-500">إدارة المطاعم، خانات الوجبات، وتوزيع السكن.</p>
                </div>
            </a>
        </div>
    </div>

    {{-- RECENT REGISTRATIONS TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-black text-[#06205C]">أحدث تسجيلات المشاركين بالمنصة</h3>
            <a href="{{ route('admin.registrations') }}" class="text-xs font-bold text-brand-600 hover:underline">عرض كافة التسجيلات ←</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase text-slate-500 border-b border-slate-200">
                        <th class="px-4 py-3 text-start">المستخدم</th>
                        <th class="px-4 py-3 text-start">التخصص الأولمبي</th>
                        <th class="px-4 py-3 text-start">الوفد / الدولة</th>
                        <th class="px-4 py-3 text-start">الحالة</th>
                        <th class="px-4 py-3 text-end">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($recentRegistrations as $reg)
                    <tr>
                        <td class="px-4 py-3 text-slate-900 font-bold">{{ $reg->user?->name ?: 'مشارك' }}</td>
                        <td class="px-4 py-3 text-indigo-700 font-bold">{{ $reg->skill?->name_ar ?: '—' }}</td>
                        <td class="px-4 py-3 text-emerald-700 font-bold">{{ $reg->country?->name_ar ?: 'الجزائر' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $reg->status === 'APPROVED' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                {{ $reg->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-end font-mono text-slate-400">{{ $reg->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-400 font-bold">لا توجد تسجيلات حديثة.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
