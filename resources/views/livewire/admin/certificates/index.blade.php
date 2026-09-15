<div class="space-y-6 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-[#06205C]">مركز استخراج الشهادات الرسمية والتقديرية</h1>
                <p class="text-xs text-slate-500 font-medium">
                    استخراج وطباعة شهادات التتويج للميداليات (ذهبية، فضية، برونزية)، شهادات المشاركة، وشهادات التقدير للحكام، المنظمين، المتطوعين والصحفيين.
                </p>
            </div>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-2xl p-4 shadow-sm">
            <span class="text-xs font-bold flex items-center gap-1.5"><x-ws.icon name="trophy" class="w-4 h-4 text-amber-200" /> الميداليات الذهبية</span>
            <span class="text-2xl font-black font-mono block mt-1">{{ $goldCount }}</span>
        </div>
        <div class="bg-gradient-to-br from-slate-400 to-slate-500 text-white rounded-2xl p-4 shadow-sm">
            <span class="text-xs font-bold flex items-center gap-1.5"><x-ws.icon name="medal" class="w-4 h-4 text-slate-200" /> الميداليات الفضية</span>
            <span class="text-2xl font-black font-mono block mt-1">{{ $silverCount }}</span>
        </div>
        <div class="bg-gradient-to-br from-amber-700 to-amber-800 text-white rounded-2xl p-4 shadow-sm">
            <span class="text-xs font-bold flex items-center gap-1.5"><x-ws.icon name="medal" class="w-4 h-4 text-amber-300" /> الميداليات البرونزية</span>
            <span class="text-2xl font-black font-mono block mt-1">{{ $bronzeCount }}</span>
        </div>
        <div class="bg-gradient-to-br from-brand-600 to-brand-700 text-white rounded-2xl p-4 shadow-sm">
            <span class="text-xs font-bold flex items-center gap-1.5"><x-ws.icon name="document-check" class="w-4 h-4 text-blue-200" /> مجموع الشهادات الصادرة</span>
            <span class="text-2xl font-black font-mono block mt-1">{{ $totalCerts }}</span>
        </div>
    </div>

    {{-- SEARCH & FILTER --}}
    <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="w-full sm:w-80 relative">
            <input type="text" wire:model.live="search" placeholder="بحث باسم المسجل أو رقم التسجيل..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-[#06205C] focus:ring-2 focus:ring-brand-500 bg-slate-50">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex items-center gap-2 overflow-x-auto w-full sm:w-auto pb-1 sm:pb-0">
            <span class="text-xs font-bold text-slate-500 whitespace-nowrap">تصفية نوع الشهادة:</span>
            <select wire:model.live="filterType" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-black text-[#06205C] bg-white">
                <option value="">جميع فئات الشهادات (All Certificates)</option>
                <option value="WINNER_GOLD">الميدالية الذهبية (Gold Medal - 1st Place)</option>
                <option value="WINNER_SILVER">الميدالية الفضية (Silver Medal - 2nd Place)</option>
                <option value="WINNER_BRONZE">الميدالية البرونزية (Bronze Medal - 3rd Place)</option>
                <option value="PARTICIPATION">شهادة المشاركة (Participation)</option>
                <option value="EXPERT_JUDGE">شهادة تقدير للحكام والخبراء (Expert Judge)</option>
                <option value="ORGANIZER">شهادة تقدير للمنظمين (Organizer)</option>
                <option value="VOLUNTEER">شهادة تقدير للمتطوعين (Volunteer)</option>
                <option value="MEDIA">شهادة تقدير للإعلاميين والصحافة (Media)</option>
            </select>
        </div>
    </div>

    {{-- REGISTRATIONS & CERTIFICATE ACTIONS TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-4 text-start">المستفيد / المترشح</th>
                        <th class="px-5 py-4 text-start">رقم التسجيل</th>
                        <th class="px-5 py-4 text-start">التخصص / الدولة</th>
                        <th class="px-5 py-4 text-center">خيارات شهادات التتويج والتقدير الرسمية</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($registrations as $reg)
                        @php
                            $num = $reg->registration_number;
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $reg->photo_url }}" alt="Photo" class="w-10 h-10 rounded-xl object-cover border border-slate-200 shrink-0">
                                    <div>
                                        <span class="font-black text-[#06205C] block text-xs">
                                            {{ $reg->participant?->first_name_ar ?? $reg->user?->name ?? 'مسجل' }} {{ $reg->participant?->last_name_ar }}
                                        </span>
                                        <span class="text-[10px] text-slate-400 font-mono block">
                                            {{ $reg->participant?->first_name_latin }} {{ $reg->participant?->last_name_latin }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-mono font-bold text-brand-600">{{ $num }}</td>
                            <td class="px-5 py-4">
                                <span class="block font-bold text-slate-800">{{ $reg->skill?->name_ar ?? 'تخصص مهني' }}</span>
                                <span class="text-[10px] text-slate-500 block">{{ $reg->country?->name_ar ?? 'الجزائر' }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    <!-- Gold Winner -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_GOLD']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة الميدالية الذهبية (المركز الأول)">
                                        <x-ws.icon name="trophy" class="w-3.5 h-3.5 inline-block me-1" /> ذهبية
                                    </a>
                                    <!-- Silver Winner -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_SILVER']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-400 hover:bg-slate-500 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة الميدالية الفضية (المركز الثاني)">
                                        <x-ws.icon name="medal" class="w-3.5 h-3.5 inline-block me-1" /> فضية
                                    </a>
                                    <!-- Bronze Winner -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'WINNER_BRONZE']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-amber-700 hover:bg-amber-800 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة الميدالية البرونزية (المركز الثالث)">
                                        <x-ws.icon name="medal" class="w-3.5 h-3.5 inline-block me-1" /> برونزية
                                    </a>
                                    <!-- Participation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'PARTICIPATION']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة مشاركة وتأهل">
                                        <x-ws.icon name="document-check" class="w-3.5 h-3.5 inline-block me-1" /> مشاركة
                                    </a>
                                    <!-- Expert Judge Appreciation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'EXPERT_JUDGE']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة تقدير حكم خبير">
                                        <x-ws.icon name="scale" class="w-3.5 h-3.5 inline-block me-1" /> حكم
                                    </a>
                                    <!-- Organizer Appreciation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'ORGANIZER']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-slate-700 hover:bg-slate-800 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة تقدير لمنظم">
                                        <x-ws.icon name="building-office-2" class="w-3.5 h-3.5 inline-block me-1" /> منظم
                                    </a>
                                    <!-- Volunteer Appreciation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'VOLUNTEER']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة تقدير لمتطوع">
                                        <x-ws.icon name="hand-raised" class="w-3.5 h-3.5 inline-block me-1" /> متطوع
                                    </a>
                                    <!-- Media Appreciation -->
                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'MEDIA']) }}" target="_blank" class="px-2.5 py-1 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-[11px] transition shadow-2xs" title="شهادة تقدير صحفي إعلامي">
                                        <x-ws.icon name="newspaper" class="w-3.5 h-3.5 inline-block me-1" /> صحفي
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-slate-400 font-bold">
                                لا يوجد نتائج تطابق البحث حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($registrations->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">{{ $registrations->links() }}</div>
        @endif
    </div>

</div>
