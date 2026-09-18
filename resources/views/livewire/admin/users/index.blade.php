@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- ═════════════════════════════════════════════════════════════════════
         1. EXECUTIVE ROYAL USERS BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-slate-950 text-white rounded-3xl p-6 sm:p-8 shadow-2xl relative overflow-hidden border border-slate-800">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-950/80 border border-blue-800/60 text-xs font-mono font-bold text-amber-400">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>WORLDSKILLS ALGERIA 2026</span>
                </div>
                
                <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight">
                    إدارة وتوجيه مستخدمي المنصة والحسابات
                </h1>
                
                <p class="text-xs sm:text-sm text-slate-300 font-bold max-w-2xl">
                    المركز الموحد لإدارة حسابات المسجلين، تحديد الأدوار والصلاحيات، التصفية حسب الولايات، الدول، والمؤسسات التكوينية.
                </p>
            </div>

            {{-- Quick Operations Action Hub --}}
            <div class="flex items-center flex-wrap gap-3 shrink-0">
                <button 
                    wire:click="openCreateModal" 
                    class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-blue-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>إنشاء حساب جديد</span>
                </button>

                <button 
                    wire:click="exportExcel" 
                    class="px-5 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm shadow-xl transition flex items-center gap-2 border border-emerald-400/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>تصدير Excel (CSV)</span>
                </button>

                <button 
                    wire:click="toggleOfficialRegistration" 
                    class="px-4 py-3 rounded-2xl font-black text-xs shadow-xl transition flex items-center gap-2 border {{ $officialRegistrationOpen ? 'bg-amber-600 hover:bg-amber-500 text-white border-amber-400/30' : 'bg-slate-800 text-slate-300 border-slate-700' }}">
                    <span class="w-2 h-2 rounded-full {{ $officialRegistrationOpen ? 'bg-emerald-400 animate-pulse' : 'bg-rose-500' }}"></span>
                    <span>التسجيل الرسمي: {{ $officialRegistrationOpen ? 'مفتوح' : 'مغلق' }}</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         2. ACTION FEEDBACK BANNER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if (session()->has('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm font-bold flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         3. STATISTICAL KPI METRICS GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-slate-500 dark:text-slate-400 block uppercase">إجمالي الحسابات بالنظام</span>
            <span class="text-3xl font-black text-slate-900 dark:text-white tracking-tight block">{{ number_format($totalUsers) }}</span>
            <span class="text-[11px] font-bold text-slate-400 block">كافة المستخدمين المسجلين</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 block uppercase">حسابات مفعلة (Active)</span>
            <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight block">{{ number_format($activeUsers) }}</span>
            <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-500 block">{{ $totalUsers > 0 ? round(($activeUsers/$totalUsers)*100, 1) : 0 }}% من الحسابات</span>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-black text-rose-600 dark:text-rose-400 block uppercase">حسابات معطلة (Inactive)</span>
            <span class="text-3xl font-black text-rose-600 dark:text-rose-400 tracking-tight block">{{ number_format($inactiveUsers) }}</span>
            <span class="text-[11px] font-bold text-rose-700 dark:text-rose-500 block">تستلزم التفعيل</span>
        </div>
    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         4. COMPREHENSIVE 5-FILTER CONTROLS HUB (الولاية، الدور، الحالة، المركز، الدولة)
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
        
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-xs font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                <span>تصفية وفلترة نتائج البحث بالكامل</span>
            </h3>

            @if($search || $filterRole || $filterStatus !== '' || $filterWilaya || $filterCountry || $filterOrganization)
                <button wire:click="resetFilters" class="text-xs font-black text-rose-600 hover:underline flex items-center gap-1">
                    <span>إعادة ضبط الفلاتر ✕</span>
                </button>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
            
            {{-- Filter 1: Search --}}
            <div class="col-span-1 sm:col-span-2 md:col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 mb-1">البحث بالاسم أو البريد أو UUID</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="ابحث باسم الحساب، البريد الإلكتروني..." 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
            </div>

            {{-- Filter 2: Role --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الدور / الصلاحية</label>
                <select 
                    wire:model.live="filterRole" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الأدوار</option>
                    @foreach($allRoles as $roleName)
                        <option value="{{ $roleName }}">{{ $roleName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter 3: Wilaya --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الولاية</label>
                <select 
                    wire:model.live="filterWilaya" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الولايات (58 ولاية)</option>
                    @foreach($wilayas as $w)
                        <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter 4: Country --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب الدولة</label>
                <select 
                    wire:model.live="filterCountry" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الدول</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso2 }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter 5: Status --}}
            <div>
                <label class="block text-[10px] font-bold text-slate-500 mb-1">تصفية حسب حالة التفعيل</label>
                <select 
                    wire:model.live="filterStatus" 
                    class="w-full px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">جميع الحالات</option>
                    <option value="1">مفعل (Active)</option>
                    <option value="0">غير مفعل (Inactive)</option>
                </select>
            </div>

        </div>

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         5. USERS LIST TABLE GRID
    ═════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 font-bold uppercase">
                    <tr>
                        <th class="px-5 py-4 text-start">المستخدم بالحساب</th>
                        <th class="px-5 py-4 text-start">الدور والصلاحية</th>
                        <th class="px-5 py-4 text-start">الولاية / الدولة</th>
                        <th class="px-5 py-4 text-start">المؤسسة التكوينية</th>
                        <th class="px-5 py-4 text-center">حالة التفعيل</th>
                        <th class="px-5 py-4 text-center">مسح QR</th>
                        <th class="px-5 py-4 text-end">إجراءات التحكم</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold">
                    @forelse($users as $user)
                        @php
                            $roleName = $user->roles->first()?->name ?? 'مستخدم عام';
                            $roleColor = match($roleName) {
                                'SUPER_ADMIN' => 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300',
                                'JUDGE', 'EXPERT' => 'bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300',
                                'ORGANIZATION_ADMIN' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                'COUNTRY_ADMIN' => 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300',
                                'CANDIDATE', 'PARTICIPANT' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300',
                                default => 'bg-slate-100 text-slate-800 dark:bg-slate-900 dark:text-slate-300',
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/40 transition">
                            
                            {{-- User Info --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $user->avatar_url }}" 
                                        alt="{{ $user->name }}" 
                                        class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0"
                                    />
                                    <div>
                                        <h4 class="font-black text-slate-900 dark:text-white text-xs">{{ $user->name }}</h4>
                                        <span class="font-mono text-[11px] text-slate-500 font-normal block">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Role --}}
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-xl text-[11px] font-black {{ $roleColor }}">
                                    {{ $roleName }}
                                </span>
                            </td>

                            {{-- Location (Wilaya & Country) --}}
                            <td class="px-5 py-4">
                                <div class="space-y-0.5">
                                    <span class="text-slate-900 dark:text-white block text-xs">
                                        {{ $user->wilaya?->name_ar ?? 'الولايات العامة' }}
                                    </span>
                                    <span class="text-slate-400 text-[10px] font-mono block">
                                        {{ $user->country?->name_ar ?? 'الجزائر (DZ)' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Organization --}}
                            <td class="px-5 py-4">
                                <span class="text-slate-600 dark:text-slate-300 text-xs line-clamp-1 max-w-[200px]">
                                    {{ $user->organization?->name_ar ?? 'غير محددة' }}
                                </span>
                            </td>

                            {{-- Active Status Toggle --}}
                            <td class="px-5 py-4 text-center">
                                <button 
                                    wire:click="toggleActive({{ $user->id }})" 
                                    class="px-3 py-1 rounded-xl text-[11px] font-black transition {{ $user->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300' }}">
                                    {{ $user->is_active ? 'مفعل ✓' : 'معطل ✕' }}
                                </button>
                            </td>

                            {{-- QR Scan Permission Toggle --}}
                            <td class="px-5 py-4 text-center">
                                <button 
                                    wire:click="toggleScanQrPermission({{ $user->id }})" 
                                    class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-black transition {{ $user->can_scan_qr ? 'bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300' : 'bg-slate-100 text-slate-500 dark:bg-slate-900' }}">
                                    {{ $user->can_scan_qr ? 'ممنوح QR' : 'غير ممنوح' }}
                                </button>
                            </td>

                            {{-- Actions --}}
                            <td class="px-5 py-4 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button 
                                        wire:click="openDrawer({{ $user->id }})" 
                                        title="عرض التفاصيل" 
                                        class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <button 
                                        wire:click="openRoleModal({{ $user->id }})" 
                                        title="تغيير الدور والصلاحيات" 
                                        class="p-2 rounded-xl bg-purple-50 hover:bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                                    </button>

                                    <button 
                                        wire:click="confirmDelete({{ $user->id }})" 
                                        title="حذف الحساب" 
                                        class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 dark:bg-rose-950 text-rose-600 dark:text-rose-400 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400 font-bold">
                                لم يتم العثور على أي حسابات مطابقة لفلاتر البحث المحددة.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-700">
                {{ $users->links() }}
            </div>
        @endif

    </div>

    {{-- ═════════════════════════════════════════════════════════════════════
         6. CREATE USER MODAL
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($createModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 w-full max-w-lg shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        إنشاء حساب جديد وتوليد بيانات الدخول
                    </h3>
                    <button wire:click="$set('createModalOpen', false)" class="text-slate-400 hover:text-slate-600 font-black text-sm">✕</button>
                </div>

                <div class="space-y-3 text-xs font-bold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">الاسم الكامل / الجهة *</label>
                        <input wire:model="create_name" type="text" placeholder="مثال: مسؤول الوفد الجزائري" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">البريد الإلكتروني الرسمي *</label>
                        <input wire:model="create_email" type="email" placeholder="official@worldskills.dz" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                    </div>

                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1">نوع الحساب والصلاحية *</label>
                        <select wire:model="create_role" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                            @foreach($allRoles as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الولاية (اختياري)</label>
                            <select wire:model="create_wilaya_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                                <option value="">بدون تخصيص ولاية</option>
                                @foreach($wilayas as $w)
                                    <option value="{{ $w->id }}">{{ $w->code }} - {{ $w->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1">الدولة (اختياري)</label>
                            <select wire:model="create_country_id" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                                <option value="">الجزائر (افتراضي)</option>
                                @foreach($countries as $c)
                                    <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-slate-700 dark:text-slate-300">كلمة السر *</label>
                            <button type="button" wire:click="generateNewPassword" class="text-[10px] text-blue-600 dark:text-blue-400 hover:underline">
                                توليد كلمة سر عشوائية
                            </button>
                        </div>
                        <input wire:model="create_password" type="text" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-mono font-bold text-center text-sm tracking-wider">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="$set('createModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">إلغاء</button>
                    <button wire:click="saveUser" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">حفظ وإنشاء الحساب</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ═════════════════════════════════════════════════════════════════════
         7. USER DETAILS DRAWER
    ═════════════════════════════════════════════════════════════════════ --}}
    @if($drawerOpen && $selectedUser)
        <div class="fixed inset-0 z-50 bg-slate-950/70 backdrop-blur-sm flex items-center justify-end p-4">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full h-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800 space-y-6 overflow-y-auto">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $selectedUser->avatar_url }}" alt="{{ $selectedUser->name }}" class="w-12 h-12 rounded-2xl object-cover border border-slate-200 dark:border-slate-700">
                        <div>
                            <h3 class="font-black text-slate-900 dark:text-white text-sm">{{ $selectedUser->name }}</h3>
                            <span class="font-mono text-xs text-slate-400">{{ $selectedUser->email }}</span>
                        </div>
                    </div>
                    <button wire:click="closeDrawer" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center font-black">✕</button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 space-y-2">
                        <span class="text-slate-400 font-bold block text-[10px]">رمز الحساب (UUID)</span>
                        <span class="font-mono font-black text-blue-600 dark:text-blue-400 text-xs block">{{ $selectedUser->uuid }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">الولاية</span>
                            <span class="font-black text-slate-900 dark:text-white">{{ $selectedUser->wilaya?->name_ar ?? 'غير محددة' }}</span>
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                            <span class="text-slate-400 block text-[10px]">الدولة</span>
                            <span class="font-black text-slate-900 dark:text-white">{{ $selectedUser->country?->name_ar ?? 'الجزائر' }}</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40">
                        <span class="text-slate-400 block text-[10px]">المؤسسة التكوينية</span>
                        <span class="font-black text-slate-900 dark:text-white">{{ $selectedUser->organization?->name_ar ?? 'غير محددة' }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/40 flex items-center justify-between">
                        <span class="text-slate-400 block text-[10px]">صلاحية مسح QR</span>
                        <span class="font-black {{ $selectedUser->can_scan_qr ? 'text-emerald-600' : 'text-slate-500' }}">{{ $selectedUser->can_scan_qr ? 'ممنوح' : 'غير ممنوح' }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="closeDrawer" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300">
                        إغلاق النافذة
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ════ EDIT ROLE MODAL ════ --}}
    @if($roleModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">تعديل دور وصلاحية المستخدم</h3>
                    <button wire:click="$set('roleModalOpen', false)" class="text-slate-400 hover:text-slate-600 font-black">✕</button>
                </div>

                <div class="space-y-3 text-xs font-bold">
                    <label class="block text-slate-700 dark:text-slate-300">اختر الدور الجديد *</label>
                    <select wire:model="newRole" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-bold">
                        @foreach($allRoles as $role)
                            <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="$set('roleModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">إلغاء</button>
                    <button wire:click="saveRole" class="px-6 py-2.5 text-xs font-black text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow-md">تحديث الدور</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ════ DELETE CONFIRMATION MODAL ════ --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm">
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-800 space-y-4 text-center">
                <h3 class="text-base font-black text-rose-600">تأكيد حذف الحساب النهائي</h3>
                <p class="text-xs text-slate-500 font-bold">هل أنت تأكد من رغبتك في حذف هذا الحساب نهائياً من قاعدة البيانات؟ لا يمكن التراجع عن هذا الإجراء.</p>

                <div class="flex items-center justify-center gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 rounded-xl">إلغاء</button>
                    <button wire:click="deleteUser" class="px-6 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
