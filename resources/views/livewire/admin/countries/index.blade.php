<div class="space-y-6 pb-12">
    <!-- TOP HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs backdrop-blur-md">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-2xl shadow-inner border border-amber-500/20">
                    🌍
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        إدارة الدول والوفود الوطنية
                    </h1>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                        إدارة المراجع المعتمدة والدول المشاركة في منصة WorldSkills Africa
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            <button wire:click="exportExcel" class="px-4 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition flex items-center gap-2 border border-slate-200/60 dark:border-slate-600/60 shadow-xs">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>تصدير Excel / CSV</span>
            </button>
            <button wire:click="openCreate" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 active:scale-98 text-white font-black text-xs transition flex items-center gap-2 shadow-lg shadow-amber-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>إضافة دولة جديدة</span>
            </button>
        </div>
    </div>

    <!-- STATS CARDS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Countries -->
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي الدول المعتمدة</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1 font-mono">{{ number_format($totalCountries) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V8.5M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
            </div>
        </div>

        <!-- Active Countries -->
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">الدول المفعلة والمشاركة</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 font-mono">{{ number_format($activeCountries) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <!-- African Union Coverage -->
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <div class="flex items-center gap-1.5">
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">تغطية الاتحاد الأفريقي</p>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-purple-100 text-purple-700 dark:bg-purple-950 dark:text-purple-300">
                        {{ round(($africanCountries / 54) * 100) }}%
                    </span>
                </div>
                <p class="text-2xl font-black text-purple-600 dark:text-purple-400 mt-1 font-mono">
                    {{ $africanCountries }} <span class="text-xs text-slate-400 font-normal">/ 54 دولة</span>
                </p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-600 dark:text-purple-400 flex items-center justify-center font-bold">
                🌍
            </div>
        </div>

        <!-- Total Registrations -->
        <div class="bg-white dark:bg-slate-800/80 p-5 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">إجمالي المسجلين المعتمدين</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1 font-mono">{{ number_format($totalRegistrations) }}</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- FILTER TOOLBAR & TABLE CARD -->
    <div class="bg-white dark:bg-slate-800/80 rounded-3xl border border-slate-200/80 dark:border-slate-700/60 shadow-xs overflow-hidden backdrop-blur-md">
        <!-- Search & Filter Controls Header -->
        <div class="p-5 border-b border-slate-100 dark:border-slate-700/60 flex flex-col md:flex-row gap-3 items-stretch md:items-center justify-between">
            <div class="flex items-center gap-2 flex-1 max-w-md">
                <div class="relative w-full">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم الدولة (عربي / فرنسي) أو الرمز ISO..." class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <div class="absolute left-3 top-3 text-slate-400 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 flex-wrap">
                <!-- Scope Filter -->
                <select wire:model.live="filterScope" class="px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">جميع النطاقات (أفريقية ودولية)</option>
                    <option value="africa">🌍 دول أفريقية فقط</option>
                    <option value="international">🌐 دول دولية خارج أفريقيا</option>
                </select>

                <!-- Status Filter -->
                <select wire:model.live="filterStatus" class="px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">جميع الحالات</option>
                    <option value="1">مفعّلة فقط</option>
                    <option value="0">معطّلة فقط</option>
                </select>

                <!-- Has Registrations Filter -->
                <select wire:model.live="filterHasRegs" class="px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">جميع التسجيلات</option>
                    <option value="with_regs">بها مسجلون معتمدون</option>
                    <option value="without_regs">بدون مسجلين</option>
                </select>
            </div>
        </div>

        <!-- Bulk Action Bar -->
        @if(count($selectedCountries ?? []) > 0)
            <div class="bg-amber-50 dark:bg-amber-950/40 p-3 px-5 border-b border-amber-200 dark:border-amber-800/60 flex items-center justify-between transition">
                <div class="flex items-center gap-2 text-xs font-bold text-amber-900 dark:text-amber-200">
                    <span>تم تحديد <strong class="font-black text-amber-700 dark:text-amber-400">{{ count($selectedCountries ?? []) }}</strong> دولة</span>
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="bulkToggleActive(true)" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                        تفعيل المحددة
                    </button>
                    <button wire:click="bulkToggleActive(false)" class="px-3 py-1.5 rounded-xl bg-slate-600 hover:bg-slate-700 text-white font-bold text-xs shadow-xs transition">
                        تعطيل المحددة
                    </button>
                </div>
            </div>
        @endif

        <!-- DATA TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700/60">
                    <tr>
                        <th class="p-4 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-500">
                        </th>
                        <th class="p-4 text-start">الدولة / الوفد الرسمي</th>
                        <th class="p-4 text-center">الرمز ISO</th>
                        <th class="p-4 text-center">النطاق والاتصال</th>
                        <th class="p-4 text-center">المسجلون المعتمدون</th>
                        <th class="p-4 text-center">متطلبات السفر</th>
                        <th class="p-4 text-center">الحالة</th>
                        <th class="p-4 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                    @forelse($countries as $c)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/30 transition">
                            <!-- Checkbox -->
                            <td class="p-4 text-center">
                                <input type="checkbox" wire:model.live="selectedCountries" value="{{ (string)$c->id }}" class="rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-500">
                            </td>

                            <!-- Country Name & Flag -->
                            <td class="p-4 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-black text-base flex items-center justify-center border border-slate-200 dark:border-slate-600 shrink-0 shadow-xs">
                                        {{ $c->flag ?: mb_substr($c->name_ar, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-white text-xs flex items-center gap-1.5">
                                            <span>{{ $c->name_ar }}</span>
                                            @if($c->is_algeria)
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">البلد المنظم</span>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-slate-400 dark:text-slate-400 font-normal font-mono mt-0.5">
                                            {{ $c->name_fr }} {{ $c->name_en ? '• ' . $c->name_en : '' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- ISO Codes -->
                            <td class="p-4 text-center font-mono">
                                <div class="inline-flex items-center gap-1 bg-slate-100 dark:bg-slate-900 px-2.5 py-1 rounded-xl border border-slate-200/80 dark:border-slate-700/80">
                                    <span class="font-black text-amber-600 dark:text-amber-400 text-xs">{{ $c->iso2 ?: '—' }}</span>
                                    <span class="text-slate-400 dark:text-slate-500 text-[10px]">• {{ $c->iso3 ?: '—' }}</span>
                                </div>
                            </td>

                            <!-- Scope & Phone Code -->
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    @if($c->is_african)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-purple-50 text-purple-700 border border-purple-200/80 dark:bg-purple-950/60 dark:text-purple-300 dark:border-purple-800/60">
                                            🌍 أفريقية
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-blue-700 border border-blue-200/80 dark:bg-blue-950/60 dark:text-blue-300 dark:border-blue-800/60">
                                            🌐 دولية
                                        </span>
                                    @endif

                                    @if($c->phone_code)
                                        <span class="font-mono text-[10px] font-bold text-slate-500 dark:text-slate-400" dir="ltr">
                                            +{{ ltrim($c->phone_code, '+') }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Registrations Count -->
                            <td class="p-4 text-center">
                                <a href="{{ route('admin.registrations') }}?country={{ $c->id }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-2xl font-mono font-black text-xs transition {{ ($c->registrations_count ?? 0) > 0 ? 'bg-amber-100 text-amber-900 dark:bg-amber-950/80 dark:text-amber-300 hover:scale-105' : 'bg-slate-100 text-slate-400 dark:bg-slate-900 dark:text-slate-500' }}">
                                    <span>{{ number_format($c->registrations_count ?? 0) }}</span>
                                    <span class="text-[10px] font-normal font-sans">مسجل</span>
                                </a>
                            </td>

                            <!-- Passport Requirement -->
                            <td class="p-4 text-center">
                                @if($c->requires_passport)
                                    <span class="px-2.5 py-1 rounded-xl text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800/60">
                                        🛂 جواز سفر مطلوب
                                    </span>
                                @else
                                    <span class="text-[10px] text-slate-400 dark:text-slate-400 font-bold">
                                        هوية أو جواز
                                    </span>
                                @endif
                            </td>

                            <!-- Active Status Toggle -->
                            <td class="p-4 text-center whitespace-nowrap">
                                <button wire:click="toggleActive({{ $c->id }})" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black transition border {{ $c->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800/60 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:border-slate-700 hover:bg-slate-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $c->is_active ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                                    <span>{{ $c->is_active ? 'نشطة ومتاحة' : 'معطّلة' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="p-4 text-end">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="openDrawer({{ $c->id }})" class="p-2 rounded-xl text-slate-400 hover:text-amber-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="عرض التفاصيل الكاملة">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                    <button wire:click="openEdit({{ $c->id }})" class="p-2 rounded-xl text-slate-400 hover:text-blue-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $c->id }})" class="p-2 rounded-xl text-slate-400 hover:text-rose-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400 dark:text-slate-500 font-bold">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <div class="text-3xl">🔍</div>
                                    <p class="text-sm">لا توجد دول مطابقة لخيارات البحث المحددة.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($countries->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                {{ $countries->links() }}
            </div>
        @endif
    </div>

    <!-- CREATE / EDIT MODAL -->
    @if($formOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs transition-all">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-lg w-full p-6 space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span>{{ $isEditing ? 'تعديل بيانات الدولة' : 'إضافة دولة جديدة' }}</span>
                    </h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1.5 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" class="space-y-4">
                    <!-- Arabic & French Names -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الاسم بالعربية *</label>
                            <input type="text" wire:model="name_ar" required placeholder="مثال: الجزائر" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('name_ar') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الاسم بالفرنسية *</label>
                            <input type="text" wire:model="name_fr" required placeholder="مثال: Algérie" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            @error('name_fr') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- English Name & Phone Code -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الاسم بالإنجليزية</label>
                            <input type="text" wire:model="name_en" placeholder="Algeria" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">مفتاح الاتصال (Phone Code)</label>
                            <input type="text" wire:model="phone_code" placeholder="213" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500" dir="ltr">
                        </div>
                    </div>

                    <!-- ISO Codes & Flag -->
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الرمز ISO2</label>
                            <input type="text" wire:model="iso2" placeholder="DZ" maxlength="2" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono uppercase font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-center">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الرمز ISO3</label>
                            <input type="text" wire:model="iso3" placeholder="DZA" maxlength="3" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono uppercase font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-center">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">العلم (Emoji)</label>
                            <input type="text" wire:model="flag" placeholder="🇩🇿" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500 text-center">
                        </div>
                    </div>

                    <!-- Nationality -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الجنسية بالعربية</label>
                            <input type="text" wire:model="nationality_ar" placeholder="جزائري" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 mb-1">الجنسية بالفرنسية</label>
                            <input type="text" wire:model="nationality_fr" placeholder="Algérienne" class="w-full px-3.5 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>
                    </div>

                    <!-- Checkboxes & Toggles -->
                    <div class="space-y-2 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700/60">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">دولة أفريقية (عضو الاتحاد الأفريقي)</span>
                            <input type="checkbox" wire:model="is_african" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 w-4 h-4">
                        </label>
                        <hr class="border-slate-200/60 dark:border-slate-700/60">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">اشتراط جواز سفر إجباري للتسجيل</span>
                            <input type="checkbox" wire:model="requires_passport" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 w-4 h-4">
                        </label>
                        <hr class="border-slate-200/60 dark:border-slate-700/60">
                        <label class="flex items-center justify-between cursor-pointer">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">تفعيل الدولة وإتاحتها للتسجيل</span>
                            <input type="checkbox" wire:model="is_active" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500 w-4 h-4">
                        </label>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="button" wire:click="$set('formOpen', false)" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-2xl transition">إلغاء</button>
                        <button type="submit" class="px-6 py-2.5 text-xs font-black text-white bg-amber-500 hover:bg-amber-600 rounded-2xl shadow-lg shadow-amber-500/20 transition">حفظ البيانات</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- COUNTRY DETAILS DRAWER -->
    @if(($drawerOpen ?? false) && ($selected ?? null))
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-md bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto p-6 space-y-6">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl font-black shrink-0 border border-amber-500/20">
                            {{ $selected->flag ?: mb_substr($selected->name_ar, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white">{{ $selected->name_ar }}</h2>
                            <div class="flex items-center gap-2 font-mono text-xs text-amber-600 dark:text-amber-400 font-bold">
                                <span>ISO: {{ $selected->iso2 ?: '—' }} / {{ $selected->iso3 ?: '—' }}</span>
                            </div>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Info Cards -->
                <div class="space-y-4 text-xs font-semibold flex-1">
                    <div class="bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl space-y-3 border border-slate-100 dark:border-slate-700/60">
                        <div class="flex justify-between items-center"><span class="text-slate-400">الاسم بالفرنسية:</span><span class="font-bold text-slate-900 dark:text-white font-mono">{{ $selected->name_fr ?? '—' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">الاسم بالإنجليزية:</span><span class="font-bold text-slate-900 dark:text-white font-mono">{{ $selected->name_en ?? '—' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">الجنسية الرسمية:</span><span class="font-bold text-slate-900 dark:text-white">{{ $selected->nationality_ar ?? '—' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">مفتاح الاتصال:</span><span class="font-bold font-mono text-slate-900 dark:text-white" dir="ltr">+{{ ltrim($selected->phone_code ?? '—', '+') }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">النطاق الجغرافي:</span><span class="font-bold text-purple-600 dark:text-purple-400">{{ $selected->is_african ? 'دولة إفريقية (الاتحاد الإفريقي) 🌍' : 'دولة دولية 🌐' }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">عدد المشاركين المعتمدين:</span><span class="font-black text-amber-600 dark:text-amber-400 text-sm font-mono">{{ number_format($selected->registrations_count ?? 0) }}</span></div>
                        <div class="flex justify-between items-center"><span class="text-slate-400">حالة التفعيل:</span><span class="font-black {{ $selected->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">{{ $selected->is_active ? 'مفعّلة ومتاحة للتسجيل' : 'معطّلة' }}</span></div>
                    </div>

                    <!-- Direct Quick Actions -->
                    <a href="{{ route('admin.registrations') }}?country={{ $selected->id }}" class="w-full p-3 rounded-2xl bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 text-amber-900 dark:text-amber-300 font-bold text-xs border border-amber-200 dark:border-amber-800/60 flex items-center justify-between transition">
                        <span>عرض قائمة المشاركين المسجلين من هذه الدولة</span>
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Footer Buttons -->
                <div class="flex gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="openEdit({{ $selected->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition shadow-lg shadow-amber-500/20">تعديل البيانات</button>
                    <button wire:click="confirmDelete({{ $selected->id }})" class="flex-1 px-4 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition">حذف الدولة</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف الدولة</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">هل أنت متأكد من رغبتك في حذف هذه الدولة من مرجع النظام؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex justify-center gap-2 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="deleteCountry" class="px-5 py-2 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif
</div>
