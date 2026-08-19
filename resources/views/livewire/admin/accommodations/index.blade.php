@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-8 pb-16 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ── 1. UNIFIED LUXURY PAGE HEADER ── --}}
    <x-dashboard.page-header
        :title="$t('إدارة الإقامة وتسكين الوفود والمشاركين', 'Gestion des Hébergements & Logements', 'Accommodations & Delegation Housing')"
        :subtitle="$t('مقرات الإقامة المعتمدة: ', 'Établissements: ', 'Total Hotels: ') . $totalAccommodations . ' — ' . $t('إجمالي الأسرة المتاحة: ', 'Capacité Totale: ', 'Total Beds Available: ') . number_format($totalCapacity)"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير إلى Excel (CSV)', 'Exporter Excel (CSV)', 'Export to Excel (CSV)') }}</span>
        </button>

        <button wire:click="openAllocateModal" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            <span>{{ $t('ربط وتسكين مشارك بغرفة', 'Affecter une Chambre', 'Assign Room to Member') }}</span>
        </button>

        <button wire:click="openCreate" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إضافة فندق / سكن', 'Ajouter un Hôtel', 'Add Hotel / Housing') }}</span>
        </button>
    </x-dashboard.page-header>

    {{-- SUCCESS NOTIFICATION --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 dark:text-emerald-300 text-xs font-black flex items-center justify-between shadow-xs animate-fade-in">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- ── 2. EXECUTIVE KPI METRICS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-slate-400 dark:text-slate-400 uppercase tracking-wider block">
                    {{ $t('مقرات الإقامة المعتمدة', 'Hôtels Homologués', 'Accredited Hotels') }}
                </span>
                <p class="text-3xl font-black text-[#06205C] dark:text-white">{{ $totalAccommodations }}</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black shrink-0 border border-blue-100 dark:border-blue-800 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-wider block">
                    {{ $t('إجمالي الأسرة والطاقة الإجمالية', 'Capacité Totale', 'Total Beds Capacity') }}
                </span>
                <p class="text-3xl font-black text-emerald-900 dark:text-emerald-200">{{ number_format($totalCapacity) }}</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black shrink-0 border border-emerald-100 dark:border-emerald-800 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-amber-700 dark:text-amber-400 uppercase tracking-wider block">
                    {{ $t('المشاركون المسكنون بالفعل', 'Logés Actuellement', 'Currently Allocated') }}
                </span>
                <p class="text-3xl font-black text-amber-900 dark:text-amber-200">{{ count($allocations) }}</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-100 dark:border-amber-800 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm flex items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[11px] font-black text-purple-700 dark:text-purple-400 uppercase tracking-wider block">
                    {{ $t('جاهزية الفنادق للوفود', 'Disponibilité Hôtels', 'Hotels Availability Ratio') }}
                </span>
                <p class="text-3xl font-black text-purple-900 dark:text-purple-200">100%</p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black shrink-0 border border-purple-100 dark:border-purple-800 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

    </div>

    {{-- ── 3. MULTI-DIMENSIONAL FILTERS BAR ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 p-5 space-y-4 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                {{ $t('الفلترة المتقدمة حسب وصول الوفود والتسكين والوجهات', 'Filtrage Avancé Hébergements & Délégations', 'Advanced Housing & Delegation Filters') }}
            </h2>
            <span class="text-[10px] font-bold text-slate-400">تصفية فورية آنية</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            {{-- Search --}}
            <div>
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="{{ $t('بحث باسم الفندق أو العنوان...', 'Recherche nom ou adresse...', 'Search hotel or address...') }}"
                       class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition">
            </div>

            {{-- Country Filter --}}
            <div>
                <select wire:model.live="filterCountry" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ $t('كل الوفود والدول', 'Toutes les Délégations', 'All Country Delegations') }}</option>
                    @foreach($countries as $cnt)
                        <option value="{{ $cnt->id }}">{{ $cnt->code }} — {{ $cnt->getLocalized('name') }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Skill Filter --}}
            <div>
                <select wire:model.live="filterSkill" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ $t('كل التخصصات المعتمدة', 'Toutes les Compétences', 'All Skill Trades') }}</option>
                    @foreach($skills as $sk)
                        <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Accommodation Filter --}}
            <div>
                <select wire:model.live="filterAccommodation" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ $t('كل الفنادق والمقرات', 'Tous les Hôtels', 'All Hotels') }}</option>
                    @foreach($allAccommodationsList as $accItem)
                        <option value="{{ $accItem->id }}">{{ $accItem->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Arrival Status --}}
            <div>
                <select wire:model.live="filterArrivalStatus" class="w-full px-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ $t('حالة الوصول والتسكين', 'Statut Arrivée', 'Arrival Status') }}</option>
                    <option value="ACTIVE">{{ $t('تم الوصول والتسكين', 'Arrivé et Logé', 'Arrived & Allocated') }}</option>
                    <option value="PENDING">{{ $t('قيد الانتظار', 'En Attente', 'Pending Arrival') }}</option>
                </select>
            </div>
        </div>
    </div>

    {{-- ── 4. TABLE 1: ROOM ALLOCATIONS ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xl overflow-hidden">
        <div class="p-5 bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ $t('جدول تسكين الأفراد والوفود الرسمية في الفنادق والغرف', 'Planning d\'Affectation des Chambres', 'Official Room Allocations Table') }}</span>
            </h3>
            <span class="text-xs font-bold text-slate-400">محدث تلقائياً</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-start">
                <thead class="bg-slate-100/70 dark:bg-slate-900/40 text-slate-500 dark:text-slate-400 font-black uppercase border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-5 py-4 text-start">{{ $t('المشارك / عضو الوفد', 'Participant / Membre', 'Member / Participant') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('الوفد / الدولة', 'Délégation / Pays', 'Delegation / Country') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('التخصص', 'Compétence', 'Skill Trade') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('مقر الإقامة / الفندق', 'Hôtel / Résidence', 'Hotel / Residence') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('رقم الغرفة', 'N° Chambre', 'Room Number') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('حالة الوصول والتسكين', 'Statut Logement', 'Allocation Status') }}</th>
                        <th class="px-5 py-4 text-end">{{ $t('إجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/80">
                    @forelse($allocations as $alloc)
                        @php
                            $profile = $alloc->participantProfile;
                            $reg = $profile?->registrations?->first();
                            $country = $reg?->country?->getLocalized('name') ?? '—';
                            $countryCode = $reg?->country?->code ?? '—';
                            $skill = $reg?->skill?->name_ar ?? '—';
                            $accommodationName = $alloc->room?->accommodation?->name_ar ?? '—';
                            $roomNum = $alloc->room?->room_number ?? '—';
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <td class="px-5 py-4 font-black text-slate-900 dark:text-slate-100">
                                {{ ($profile?->first_name_ar . ' ' . $profile?->last_name_ar) ?: ($profile?->user?->name ?? '—') }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black text-[11px] border border-blue-200 dark:border-blue-800">
                                    {{ $countryCode }} — {{ $country }}
                                </span>
                            </td>
                            <td class="px-5 py-4 font-bold text-slate-700 dark:text-slate-300">{{ $skill }}</td>
                            <td class="px-5 py-4 font-black text-[#06205C] dark:text-white">{{ $accommodationName }}</td>
                            <td class="px-5 py-4 font-mono font-black text-purple-600 dark:text-purple-400">غرفة {{ $roomNum }}</td>
                            <td class="px-5 py-4">
                                @if($alloc->status === 'ACTIVE')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                        تم الوصول والتسكين
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-amber-50 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800">
                                        قيد الانتظار
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-end">
                                <button wire:click="deleteAllocation({{ $alloc->id }})" wire:confirm="هل تريد إلغاء تسكين المشارك من هذه الغرفة؟" class="p-2 text-rose-500 hover:text-rose-700 rounded-xl hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400 font-bold text-xs">
                                لا توجد عمليات تسكين مطابقة للفلتارة الحالية
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── 5. TABLE 2: ACCREDITED ACCOMMODATIONS LIST ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-xl overflow-hidden">
        <div class="p-5 bg-slate-50/80 dark:bg-slate-900/60 border-b border-slate-200/80 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-base font-black text-[#06205C] dark:text-white">
                {{ $t('قائمة مقرات الإقامة والفنادق المعتمدة', 'Hôtels & Hébergements Homologués', 'Accredited Hotels & Housing Centers') }}
            </h3>
            <span class="text-xs font-bold text-slate-400">الطاقة الاستيعابية والغرف</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-start">
                <thead class="bg-slate-100/70 dark:bg-slate-900/40 text-slate-500 dark:text-slate-400 font-black uppercase border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-5 py-4 text-start">{{ $t('الفندق / السكن', 'Hôtel / Logement', 'Hotel / Residence') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('العنوان والموقع', 'Adresse', 'Address') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('الطاقة الإجمالية', 'Capacité Totale', 'Total Capacity') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('الغرف المتاحة', 'Chambres Dispo', 'Available Rooms') }}</th>
                        <th class="px-5 py-4 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="px-5 py-4 text-end">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/80">
                    @forelse($accommodations as $acc)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <td class="px-5 py-4 font-black text-slate-900 dark:text-slate-100">
                                <button wire:click="openDrawer({{ $acc->id }})" class="hover:text-blue-600 dark:hover:text-blue-400 transition text-start">
                                    {{ $acc->name_ar }}
                                </button>
                            </td>
                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300 font-medium">{{ $acc->address ?: '—' }}</td>
                            <td class="px-5 py-4 font-mono font-black text-slate-800 dark:text-slate-200">{{ number_format($acc->total_capacity ?? 0) }} سرير</td>
                            <td class="px-5 py-4">
                                <button wire:click="openRooms({{ $acc->id }})" class="px-3 py-1.5 rounded-2xl text-xs font-black bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 hover:bg-blue-100 transition">
                                    {{ $acc->rooms_count }} غرفة
                                </button>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                                    متاح
                                </span>
                            </td>
                            <td class="px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-2">
                                    <button wire:click="openEdit({{ $acc->id }})" title="تعديل بيانات الفندق" class="p-2 text-slate-500 hover:text-blue-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $acc->id }})" title="حذف الفندق" class="p-2 text-slate-500 hover:text-rose-600 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-slate-400 font-bold text-xs">لا توجد إقامات مسجلة في المنصة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── 6. MODAL 1: ADD / EDIT HOTEL FORM MODAL ── --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto animate-scale-up">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black shrink-0 shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                                {{ $isEditing ? 'تعديل بيانات الفندق / مقر الإقامة' : 'إضافة فندق أو مقر إقامة جديد' }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-0.5">إدخال البيانات الأساسية لمقر الإقامة المعتمد للوفود والمشاركين.</p>
                        </div>
                    </div>
                    <button wire:click="$set('formOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">اسم الفندق / مقر الإقامة (بالعربية) *</label>
                        <input type="text" wire:model="name_ar" placeholder="مثال: فندق المهرجان الإفريقي - الجزائر العاصمة" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/30 transition">
                        @error('name_ar') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">اسم الفندق / مقر الإقامة (بالفرنسية) *</label>
                        <input type="text" wire:model="name_fr" placeholder="Ex: Hôtel du Festival Africain - Alger" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/30 transition">
                        @error('name_fr') <span class="text-[10px] text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">العنوان والموقع التفصيلي</label>
                        <input type="text" wire:model="address" placeholder="مثال: بن عكنون، الجزائر العاصمة" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/30 transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">رقم الهاتف والتواصل</label>
                            <input type="text" wire:model="contact_phone" placeholder="021 XX XX XX" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/30 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">الطاقة الإجمالية (عدد الأسرة)</label>
                            <input type="number" wire:model="total_capacity" placeholder="150" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500/30 transition">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" type="button" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                        إلغاء
                    </button>
                    <button wire:click="save" type="button" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition">
                        {{ $isEditing ? 'حفظ التعديلات' : 'حفظ الفندق الجديد' }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ── 7. MODAL 2: ASSIGN ROOM / ALLOCATE MODAL ── --}}
    @if($allocateModalOpen)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto animate-scale-up">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black shrink-0 shadow-md">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                                {{ $t('ربط وتسكين مشارك بغرفة وموقع مبيت', 'Affectation d\'une Chambre à un Membre', 'Assign Room to Delegation Member') }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-0.5">تصفية وااختيار المشارك والغرفة المخصصة له في السكن.</p>
                        </div>
                    </div>
                    <button wire:click="$set('allocateModalOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                <div class="space-y-5">

                    {{-- SECTION 1: PARTICIPANT SELECTION & FILTERS --}}
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700/80 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-[#06205C] dark:text-blue-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                1. تصفية واختيار المشارك (حسب الدولة أو الولاية):
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">
                                {{ count($modalParticipants) }} مشارك مطابق
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            {{-- Country Filter --}}
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">حسب الدولة / الوفد:</label>
                                <select wire:model.live="allocateCountryId" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                                    <option value="">-- كل الوفود والدول --</option>
                                    @foreach($countries as $cntOption)
                                        <option value="{{ $cntOption->id }}">{{ $cntOption->code }} — {{ $cntOption->getLocalized('name') }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Wilaya Filter (01 - 58) --}}
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">حسب الولاية الجزائرية (01-58):</label>
                                <select wire:model.live="allocateWilayaId" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                                    <option value="">-- كل الولايات الجزائرية (58) --</option>
                                    @foreach($wilayas as $wOption)
                                        <option value="{{ $wOption->id }}">{{ $wOption->code }} — {{ $wOption->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Final Participant Dropdown --}}
                        <div class="pt-1">
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">اختر المشارك أو الفرد المعتمد *</label>
                            <select wire:model="selectedParticipantId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition shadow-xs">
                                <option value="">-- اختر المشارك المطابق للفلترة --</option>
                                @foreach($modalParticipants as $part)
                                    @php
                                        $pReg = $part->registrations?->first();
                                        $pCountry = $pReg?->country?->code ?? ($part->user?->country?->code ?? '—');
                                        $pWilaya = $part->wilaya?->name_ar ?? '—';
                                        $pSkill = $pReg?->skill?->name_ar ?? '—';
                                        $pName = ($part->first_name_ar . ' ' . $part->last_name_ar) ?: ($part->user?->name ?? '—');
                                    @endphp
                                    <option value="{{ $part->id }}">
                                        [{{ $pWilaya !== '—' ? 'ولاية ' . $pWilaya : $pCountry }}] {{ $pName }} — {{ $pSkill }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- SECTION 2: HOTEL & ROOM SELECTION --}}
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700/80 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-[#06205C] dark:text-blue-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                2. تصفية وااختيار الفندق والغرفة:
                            </span>
                            <span class="text-[10px] font-bold text-slate-400">
                                {{ count($modalRooms) }} غرفة متاحة
                            </span>
                        </div>

                        {{-- Hotel Filter --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1">اختر الفندق / مقر الإقامة:</label>
                            <select wire:model.live="allocateAccommodationId" class="w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                                <option value="">-- جميع مقرات الإقامة والفنادق المعتمدة --</option>
                                @foreach($allAccommodationsList as $accOpt)
                                    <option value="{{ $accOpt->id }}">{{ $accOpt->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Room Selection --}}
                        <div class="pt-1">
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">اختر رقم الغرفة وموقع المبيت *</label>
                            <select wire:model="selectedRoomId" class="w-full px-4 py-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500/30 transition shadow-xs">
                                <option value="">-- حدد الغرفة من القائمة --</option>
                                @foreach($modalRooms as $rm)
                                    <option value="{{ $rm->id }}">
                                        {{ $rm->accommodation?->name_ar }} — غرفة {{ $rm->room_number }} (سعة {{ $rm->capacity }} أسرة)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('allocateModalOpen', false)" type="button" class="px-5 py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                        إلغاء
                    </button>
                    <button wire:click="saveAllocation" type="button" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-lg transition">
                        ربط وتسكين المشارك الآن
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ── 8. MODAL 3: ROOMS SUB-FORM MODAL ── --}}
    @if($roomsFormOpen)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto my-auto animate-scale-up">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/80 pb-4">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white">
                            إدارة غرف {{ $roomsAccommodationName }}
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-0.5">إضافة وتعديل غرف الفندق المخصص للوفود.</p>
                    </div>
                    <button wire:click="$set('roomsFormOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                {{-- Add Room Mini-Form --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 space-y-3">
                    <span class="text-xs font-black text-slate-700 dark:text-slate-300 block">إضافة غرفة جديدة:</span>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        <input type="text" wire:model="new_room_number" placeholder="رقم الغرفة (101)" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                        <input type="number" wire:model="new_capacity" placeholder="السعة (عدد الأسرة)" class="px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                        <button wire:click="addRoom" type="button" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition">
                            إضافة الغرفة
                        </button>
                    </div>
                </div>

                {{-- Existing Rooms Table --}}
                <div class="space-y-2">
                    <span class="text-xs font-black text-slate-700 dark:text-slate-300 block">الغرف المسجلة في هذا السكن:</span>
                    <div class="max-h-60 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700 border border-slate-200 dark:border-slate-700 rounded-2xl">
                        @forelse($roomsList as $rmItem)
                            <div class="p-3 flex items-center justify-between text-xs font-bold">
                                <div>
                                    <span class="font-mono font-black text-blue-600 dark:text-blue-400">غرفة {{ $rmItem['room_number'] }}</span>
                                    <span class="text-slate-400 mx-2">•</span>
                                    <span class="text-slate-600 dark:text-slate-300">{{ $rmItem['capacity'] }} أسرة</span>
                                </div>
                                <button wire:click="deleteRoom({{ $rmItem['id'] }})" class="text-rose-500 hover:text-rose-700 text-xs font-bold">حذف</button>
                            </div>
                        @empty
                            <div class="p-6 text-center text-slate-400 font-bold text-xs">لا توجد غرف مسجلة حتى الآن</div>
                        @endforelse
                    </div>
                </div>

                <div class="flex items-center justify-end pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('roomsFormOpen', false)" type="button" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs">
                        إغلاق Window
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ── 9. MODAL 4: CONFIRM DELETE MODAL ── --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-sm w-full p-6 text-center space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 animate-scale-up">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950 text-rose-600 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف الفندق ومقر الإقامة</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">هل أنت تأكد بالكامل من حذف مقر الإقامة هذا؟ سيتم إلغاء كافة الغرف المربوطة به.</p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs">إلغاء</button>
                    <button wire:click="deleteAccommodation" class="px-6 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md">نعم، احذف الفندق</button>
                </div>
            </div>
        </div>
    @endif

</div>
