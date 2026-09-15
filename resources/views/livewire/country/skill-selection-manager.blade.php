<div class="space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C]">
                    {{ $country?->getLocalized('name') ?? (app()->getLocale() === 'fr' ? 'Délégation' : (app()->getLocale() === 'en' ? 'Delegation' : 'الوفد الوطني')) }} — {{ app()->getLocale() === 'fr' ? 'Sélection des Métiers Olympiques' : (app()->getLocale() === 'en' ? 'Skill & Trade Selection' : 'اختيار وتحديد تخصصات المنافسة') }}
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    {{ app()->getLocale() === 'fr' ? 'Sélectionnez les compétences pour lesquelles la délégation présentera des candidats.' : (app()->getLocale() === 'en' ? 'Select the skill competitions your delegation will participate in.' : 'حدد المهن والتخصصات الرسمية التي يشارك فيها الوفد في الدورة الحالية.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <!-- Search Bar -->
            <div class="relative w-full sm:w-72">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher métier...' : (app()->getLocale() === 'en' ? 'Search trade code or name...' : 'ابحث باسم المهنة أو رمزها...') }}" class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C]">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <a href="{{ route('country.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if ($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-600 font-bold text-xs"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
        </div>
    @endif

    <!-- Skills Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($skills as $skill)
            @php
                $status = $selectedSkills[$skill->id] ?? null;
            @endphp
            
            <div class="bg-white rounded-3xl p-6 border shadow-sm flex flex-col justify-between space-y-4 transition hover:shadow-md {{ $status === 'APPROVED' ? 'border-emerald-300 bg-emerald-50/20' : ($status === 'REQUESTED' ? 'border-amber-300 bg-amber-50/20' : ($status === 'REJECTED' ? 'border-rose-300 bg-rose-50/20' : 'border-slate-200')) }}">
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-xl bg-brand-50 text-[#0066FF] font-mono font-black text-xs border border-brand-100">
                            {{ $skill->code }}
                        </span>

                        @if($status === 'APPROVED')
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px] flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد ومقبول') }}
                            </span>
                        @elseif($status === 'REQUESTED')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px] flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ app()->getLocale() === 'fr' ? 'Demandé' : (app()->getLocale() === 'en' ? 'Requested' : 'طلب مخصص') }}
                            </span>
                        @elseif($status === 'REJECTED')
                            <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-bold text-[10px] flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-semibold text-[10px]">
                                {{ app()->getLocale() === 'fr' ? 'Non sélectionné' : (app()->getLocale() === 'en' ? 'Not Selected' : 'غير محدد') }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-base font-black text-[#06205C] leading-snug">{{ $skill->getLocalized('name') }}</h3>
                    <p class="text-xs text-slate-500 leading-relaxed font-medium line-clamp-2">
                        {{ $skill->getLocalized('description') ?: (app()->getLocale() === 'fr' ? 'Discipline olympique officielle.' : (app()->getLocale() === 'en' ? 'Official competition skill.' : 'تخصص تقني معتمد ضمن المنافسات الأولمبية.')) }}
                    </p>

                    <div class="text-[11px] font-bold text-slate-400 flex items-center gap-2">
                        <span>{{ app()->getLocale() === 'fr' ? 'Âge:' : (app()->getLocale() === 'en' ? 'Age Limit:' : 'العمر:') }} {{ $skill->min_age ?: 16 }} - {{ $skill->max_age ?: 25 }} {{ app()->getLocale() === 'fr' ? 'ans' : (app()->getLocale() === 'en' ? 'years' : 'سنة') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button wire:click="toggleSkill({{ $skill->id }})" class="w-full py-2.5 rounded-xl font-bold text-xs transition-all flex items-center justify-center gap-2 {{ $status ? 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200' : 'bg-[#0066FF] hover:bg-[#0052CC] text-white shadow-sm' }}">
                        @if($status)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Désélectionner Métier' : (app()->getLocale() === 'en' ? 'Deselect Trade' : 'إلغاء تحديد هذا التخصص') }}</span>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Sélectionner Métier' : (app()->getLocale() === 'en' ? 'Select Trade' : 'تحديد واختيار التخصص') }}</span>
                        @endif
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full p-12 text-center text-slate-400 font-bold bg-white rounded-3xl border border-slate-200">
                {{ app()->getLocale() === 'fr' ? 'Aucune discipline trouvée.' : (app()->getLocale() === 'en' ? 'No trades found matching search.' : 'لا توجد تخصصات مطابقة لنتائج البحث.') }}
            </div>
        @endforelse
    </div>
</div>
