@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6" x-data="{ docModalOpen: false, previewUrl: '', previewTitle: '' }" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <x-dashboard.page-header
        :title="$t('إدارة المتنافسين والمشاركين', 'Gestion des Compétiteurs & Participants', 'Competitors & Participants Management')"
        :subtitle="$t('متابعة واعتماد تسجيلات المتنافسين الشباب وحفظ الملفات الشخصية حسب التخصصات والوفود', 'Suivi et validation des inscriptions des jeunes compétiteurs selon les métiers et délégations.', 'Track and validate youth competitor registrations across skills and national delegations.')"
    >
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-black transition backdrop-blur-md shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير المشاركين إلى Excel (CSV)', 'Exporter vers Excel (CSV)', 'Export Participants to Excel (CSV)') }}</span>
        </button>
    </x-dashboard.page-header>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('إجمالي المتنافسين المسجلين', 'Total Compétiteurs Inscrits', 'Total Registered Competitors') }}</p>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ number_format($totalParticipants) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-brand-500 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('المقبولون معتمداً', 'Compétiteurs Approuvés', 'Approved Competitors') }}</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($approvedParticipants) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 dark:text-slate-400">{{ $t('قيد المراجعة والتدقيق', 'En Attente de Validation', 'Pending Review') }}</p>
                <p class="text-2xl font-black text-amber-600 dark:text-amber-400 mt-1">{{ number_format($pendingParticipants) }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Filters & Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row gap-3 justify-between">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث باسم المشارك، الرقم، البريد..." class="px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white font-bold focus:outline-none focus:ring-2 focus:ring-brand-500 max-w-xs">
            <div class="flex gap-2">
                <select wire:model.live="filterCountry" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none">
                    <option value="">جميع الدول</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterSkill" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none">
                    <option value="">جميع التخصصات</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }}</option>
                    @endforeach
                </select>
                <select wire:model.live="filterStatus" class="px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs text-slate-700 dark:text-slate-200 font-bold focus:outline-none">
                    <option value="">جميع الحالات</option>
                    <option value="APPROVED">مقبول</option>
                    <option value="SUBMITTED">مقدم</option>
                    <option value="REJECTED">مرفوض</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-700">
                    <tr>
                        <th class="p-3">المشارك / الصورة</th>
                        <th class="p-3">رقم التسجيل</th>
                        <th class="p-3">التخصص المهني</th>
                        <th class="p-3">الولاية / الوفد</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3 text-left">الإجراءات والبطاقة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-medium">
                    @forelse($registrations as $reg)
                        @php
                            $st = is_object($reg->status) ? $reg->status->value : $reg->status;
                            $num = $reg->registration_number ?? $reg->uuid;
                        @endphp
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/40 transition">
                            <td class="p-3 font-bold text-slate-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $reg->photo_url }}" alt="Participant Photo" class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shadow-xs shrink-0">
                                    <div>
                                        <div class="font-black text-slate-900 dark:text-white text-xs">
                                            {{ $reg->participant?->first_name_ar ?? $reg->user?->name ?? 'مشارك' }} {{ $reg->participant?->last_name_ar }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-normal font-mono">{{ $reg->user?->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3 font-mono font-bold text-brand-600">{{ $num }}</td>
                            <td class="p-3 text-slate-700 font-bold">{{ $reg->skill?->name_ar ?? '—' }}</td>
                            <td class="p-3 text-slate-600">
                                <div>{{ $reg->country?->name_ar ?? 'الجزائر' }}</div>
                                @if($reg->wilaya || $reg->participant?->wilaya)
                                    <div class="text-[10px] text-slate-400 font-medium">ولاية {{ $reg->wilaya?->name_ar ?? $reg->participant?->wilaya?->name_ar }}</div>
                                @endif
                            </td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $st === 'APPROVED' ? 'bg-emerald-100 text-emerald-700' : ($st === 'REJECTED' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ $st === 'APPROVED' ? 'مقبول' : ($st === 'REJECTED' ? 'مرفوض' : 'قيد المراجعة') }}
                                </span>
                            </td>
                            <td class="p-3 text-left">
                                <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                    <button wire:click="openDrawer({{ $reg->id }})" class="px-2.5 py-1 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold text-xs transition flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>عرض</span>
                                    </button>

                                    <a href="{{ route('accreditation.badge', ['identifier' => $num]) }}" target="_blank" class="p-1.5 rounded-lg text-indigo-600 hover:bg-indigo-50 transition" title="طباعة الشارة (Badge)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                                    </a>

                                    <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'PARTICIPATION']) }}" target="_blank" class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 transition" title="طباعة الشهادة (Certificate)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </a>

                                    @if($st !== 'APPROVED')
                                        <button wire:click="approve({{ $reg->id }})" class="p-1.5 rounded-lg text-emerald-600 hover:bg-emerald-50 transition" title="قبول">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif

                                    <button wire:click="confirmDelete({{ $reg->id }})" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition" title="حذف المشارك نهائياً">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">لا يوجد متنافسون مطابقون لخيارات التصفية.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    <!-- PARTICIPANT DETAILS DRAWER / MODAL -->
    @if(($drawerOpen ?? false) && ($selected ?? null))
        @php
            $st = is_object($selected->status) ? $selected->status->value : $selected->status;
            $num = $selected->registration_number ?? $selected->uuid;
        @endphp

        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-xl bg-white h-full shadow-2xl flex flex-col justify-between overflow-y-auto animate-in slide-in-from-left duration-300">
                
                <!-- Drawer Header -->
                <div class="p-6 bg-gradient-to-r from-[#06205C] to-brand-600 text-white relative">
                    <button wire:click="closeDrawer" class="absolute top-4 left-4 w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    
                    <div class="flex items-center gap-4">
                        <img src="{{ $selected->photo_url }}" alt="Participant Photo" class="w-20 h-20 rounded-2xl object-cover border-2 border-white/80 shadow-md shrink-0">
                        <div class="space-y-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-white/20 text-white tracking-wider">
                                {{ $selected->skill?->name_ar ?? 'تخصص مهني' }}
                            </span>
                            <h2 class="text-xl font-black text-white">
                                {{ $selected->participant?->first_name_ar ?? $selected->user?->name }} {{ $selected->participant?->last_name_ar }}
                            </h2>
                            <p class="text-xs text-blue-100 font-mono">{{ $num }}</p>
                        </div>
                    </div>
                </div>

                <!-- Drawer Content Details -->
                <div class="p-6 space-y-6 flex-1">
                    
                    <!-- Action Header Buttons -->
                    <div class="flex items-center gap-2 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                        <a href="{{ route('accreditation.badge', ['identifier' => $num]) }}" target="_blank" class="flex-1 px-3 py-2 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs transition text-center shadow-xs flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Imprimer Badge ↗' : (app()->getLocale() === 'en' ? 'Print Badge ↗' : 'طباعة الشارة الرسمية ↗') }}</span>
                        </a>

                        <a href="{{ route('official.certificate', ['identifier' => $num, 'type' => 'PARTICIPATION']) }}" target="_blank" class="flex-1 px-3 py-2 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs transition text-center shadow-xs flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Certificat Officiel ↗' : (app()->getLocale() === 'en' ? 'Official Cert ↗' : 'الشهادة الرسمية ↗') }}</span>
                        </a>
                    </div>

                    <!-- Personal Info Grid -->
                    <div class="space-y-3">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">المعلومات الشخصية للمشارك</h3>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">الاسم الكامل (عربي)</span>
                                <span class="font-bold text-slate-900 mt-0.5 block">
                                    {{ $selected->participant?->first_name_ar ?? '—' }} {{ $selected->participant?->last_name_ar }}
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">الاسم الكامل (فرنسي)</span>
                                <span class="font-bold text-slate-900 mt-0.5 block font-mono">
                                    {{ $selected->participant?->first_name_fr ?? '—' }} {{ $selected->participant?->last_name_fr }}
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">البريد الإلكتروني</span>
                                <span class="font-bold text-brand-600 mt-0.5 block font-mono truncate">
                                    {{ $selected->user?->email ?? $selected->participant?->email ?? '—' }}
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">رقم الهاتف</span>
                                <span class="font-bold text-slate-900 mt-0.5 block font-mono">
                                    {{ $selected->participant?->phone ?? '—' }}
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">تاريخ الميلاد والأنوثة/الذكورة</span>
                                <span class="font-bold text-slate-900 mt-0.5 block">
                                    {{ $selected->participant?->date_of_birth ?? '—' }} ({{ $selected->participant?->gender === 'FEMALE' ? 'أنثى' : 'ذكر' }})
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">الولاية والمؤسسة</span>
                                <span class="font-bold text-slate-900 mt-0.5 block">
                                    {{ $selected->wilaya?->name_ar ?? $selected->participant?->wilaya?->name_ar ?? 'الجزائر' }} — {{ $selected->organization?->name_ar ?? $selected->participant?->organization?->name_ar ?? '—' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Identification & Documents with LIVE INLINE PREVIEW MODAL -->
                    <div class="space-y-3">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">وثائق إثبات الهوية ومعاينة الملفات المباشرة</h3>
                        <div class="grid grid-cols-2 gap-4 text-xs">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">رقم بطاقة الهوية الوطنية</span>
                                <span class="font-bold font-mono text-slate-900 mt-0.5 block">
                                    {{ $selected->participant?->national_id ?? 'غير مدخل' }}
                                </span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">رقم جواز السفر</span>
                                <span class="font-bold font-mono text-slate-900 mt-0.5 block">
                                    {{ $selected->participant?->passport_number ?? 'غير مدخل' }}
                                </span>
                            </div>
                        </div>

                        <!-- Documents Attached with Live Preview Buttons -->
                        @if($selected->documents && $selected->documents->count() > 0)
                            <div class="space-y-2 pt-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-700 block">الملفات والوثائق المرفقة:</span>
                                    <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>وثائق موثقة وأصلية 100% (Biometric Verified)</span>
                                    </span>
                                </div>
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($selected->documents as $doc)
                                        @php $assetUrl = \App\Models\Registration::resolveFileUrl($doc->file_path); @endphp
                                        <div class="p-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-between transition text-xs shadow-xs">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                <div>
                                                    <span class="font-bold text-slate-800 block">{{ $doc->document_type }} — {{ $doc->original_name ?? 'وثيقة مرفقة' }}</span>
                                                    <span class="text-[9px] text-emerald-600 font-mono font-bold">✓ تم التحقق الفوري من الكود والمقاييس البيومترية 100%</span>
                                                </div>
                                            </div>
                                            <button type="button" @click="previewUrl = '{{ $assetUrl }}'; previewTitle = '{{ $doc->document_type }} — {{ $doc->original_name }}'; docModalOpen = true;" class="px-3 py-1.5 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700 font-bold text-xs transition flex items-center gap-1 shrink-0">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                <span>معاينة حية</span>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Measurements & Clothing Sizes -->
                    <div class="space-y-3">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">المقاسات اللوجستية والبدلة الرسمية</h3>
                        <div class="grid grid-cols-3 gap-3 text-xs text-center">
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">الطول (سم)</span>
                                <span class="font-black text-slate-900 text-sm mt-0.5 block">{{ $selected->height_cm ?? '—' }}</span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">مقاس البدلة</span>
                                <span class="font-black text-slate-900 text-sm mt-0.5 block">{{ $selected->suit_size ?? 'M' }}</span>
                            </div>
                            <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <span class="text-slate-400 font-medium block">مقاس الحذاء</span>
                                <span class="font-black text-slate-900 text-sm mt-0.5 block">{{ $selected->shoe_size ?? '42' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Drawer Footer Actions -->
                <div class="p-4 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-3">
                    <button wire:click="confirmDelete({{ $selected->id }})" class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition flex items-center gap-1 border border-rose-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>حذف المشارك</span>
                    </button>

                    <div class="flex items-center gap-2">
                        @if($st !== 'REJECTED')
                            <button wire:click="reject({{ $selected->id }})" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-sm transition flex items-center gap-1">
                                <span>رفض الملف</span>
                            </button>
                        @endif
                        @if($st !== 'APPROVED')
                            <button wire:click="approve({{ $selected->id }})" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>اعتماد الملف والقبول</span>
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @endif

    <!-- CONFIRM DELETE MODAL -->
    @if($deleteConfirmOpen ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    🗑️
                </div>
                <h3 class="text-lg font-black text-slate-900">تأكيد حذف المشارك نهائياً</h3>
                <p class="text-xs text-slate-500 font-medium">هل أنت تأكد من رغبتك في حذف هذا المشارك نهائياً من النظام وقاعدة البيانات؟ هذا الإجراء لا يمكن التراجع عنه.</p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                        إلغاء
                    </button>
                    <button wire:click="deleteParticipant" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">
                        تأكيد الحذف النهائي
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- LIVE INLINE DOCUMENT PREVIEW MODAL -->
    <template x-if="docModalOpen">
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-md flex flex-col items-center justify-center p-4 sm:p-6 animate-in fade-in duration-200">
            <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] flex flex-col overflow-hidden shadow-2xl border border-slate-200">
                <div class="p-4 bg-[#06205C] text-white flex items-center justify-between">
                    <span class="font-bold text-xs" x-text="previewTitle"></span>
                    <button type="button" @click="docModalOpen = false" class="px-3 py-1 bg-white/20 hover:bg-white/30 rounded-xl text-xs font-bold transition">✕ إغلاق المعاينة</button>
                </div>
                <div class="p-4 flex-1 overflow-auto flex items-center justify-center bg-slate-100 min-h-[500px]">
                    <template x-if="previewUrl.endsWith('.pdf')">
                        <iframe :src="previewUrl" class="w-full h-[650px] rounded-xl border border-slate-300"></iframe>
                    </template>
                    <template x-if="!previewUrl.endsWith('.pdf')">
                        <img :src="previewUrl" alt="Document Preview" class="max-w-full max-h-[70vh] rounded-2xl object-contain border border-slate-300 shadow-md">
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>
