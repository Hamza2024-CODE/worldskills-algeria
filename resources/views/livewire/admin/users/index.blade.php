@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};

$roleBadge = [
    'SUPER_ADMIN'        => ['bg-rose-50 text-rose-700 border-rose-200',       $t('مدير النظام','Super Admin','Super Admin')],
    'EXECUTIVE_VIEWER'   => ['bg-purple-50 text-purple-700 border-purple-200', $t('المراقب الوزاري','Exécutif','Executive')],
    'COUNTRY_ADMIN'      => ['bg-blue-50 text-blue-700 border-blue-200',        $t('مسؤول الوفد','Délégation','Country Admin')],
    'ORGANIZATION_ADMIN' => ['bg-cyan-50 text-cyan-700 border-cyan-200',        $t('مسؤول مؤسسة','Établissement','Org Admin')],
    'MEDIA_MANAGER'      => ['bg-amber-50 text-amber-700 border-amber-200',     $t('إعلام وصحافة','Média','Media')],
    'JUDGE'              => ['bg-indigo-50 text-indigo-700 border-indigo-200',  $t('حكم وخبير','Juge','Judge')],
    'PARTICIPANT'        => ['bg-emerald-50 text-emerald-700 border-emerald-200',$t('مشارك متنافس','Participant','Participant')],
    'SPONSOR'            => ['bg-orange-50 text-orange-700 border-orange-200',  $t('راعي','Sponsor','Sponsor')],
];
@endphp

<div class="space-y-5 pb-8" x-data="{ drawerOpen: @entangle('drawerOpen'), roleModalOpen: @entangle('roleModalOpen'), createModalOpen: @entangle('createModalOpen'), deleteConfirmOpen: @entangle('deleteConfirmOpen') }">

    {{-- ── Page Header ── --}}
    <x-dashboard.page-header
        :title="$t('إدارة المستخدمين وحسابات الوفود والحكام والصحافة', 'Gestion des Utilisateurs', 'User Accounts & Credentials')"
        :subtitle="$t('إجمالي الحسابات','Total comptes','Total accounts') . ': ' . $totalUsers . ' — ' . $t('الحسابات النشطة','Comptes actifs','Active accounts') . ': ' . $activeUsers"
    >
        <button wire:click="toggleOfficialRegistration" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl {{ $officialRegistrationOpen ? 'bg-amber-600 hover:bg-amber-700 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }} text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>{{ $officialRegistrationOpen
                ? $t('إغلاق التسجيل الرسمي','Fermer les inscriptions','Close Registration')
                : $t('فتح التسجيل الرسمي','Ouvrir les inscriptions','Open Registration') }}</span>
        </button>
        <a href="{{ route('official.registration') }}" target="_blank" class="flex items-center gap-1.5 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-bold transition backdrop-blur-md shrink-0">
            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>{{ $t('معاينة صفحة التسجيل','Aperçu inscription','Preview Registration') }}</span>
        </a>
        <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition backdrop-blur-md shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span>{{ $t('تصدير Excel','Exporter Excel','Export Excel') }}</span>
        </button>
        <button wire:click="openCreateModal" class="flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-lg shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>{{ $t('إنشاء حساب جديد','Nouveau compte','New Account') }}</span>
        </button>
    </x-dashboard.page-header>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200">✓ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-rose-50 text-rose-700 text-xs font-bold rounded-xl border border-rose-200">⚠ {{ session('error') }}</div>
    @endif

    {{-- ── Filters Bar ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="absolute {{ $locale==='ar'?'end-3':'start-3' }} top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input wire:model.live.debounce.300ms="search" type="search"
                   placeholder="{{ $t('بحث بالاسم أو البريد الإلكتروني...','Rechercher...','Search by name or email...') }}"
                   class="w-full {{ $locale==='ar'?'pe-10 ps-4':'ps-10 pe-4' }} py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <select wire:model.live="filterRole"
                class="px-3 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الأدوار','Tous les rôles','All Roles') }}</option>
            @foreach($allRoles as $role)
                <option value="{{ $role }}">{{ $role }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus"
                class="px-3 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات','Tous statuts','All Statuses') }}</option>
            <option value="1">{{ $t('نشط','Actif','Active') }}</option>
            <option value="0">{{ $t('معطل','Désactivé','Inactive') }}</option>
        </select>
    </div>

    {{-- ── Data Table ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                        <th class="px-5 py-3.5 text-start">{{ $t('المستخدم','Utilisateur','User') }}</th>
                        <th class="px-5 py-3.5 text-start">{{ $t('الدور / الرتبة الرسمية','Rôle','Role') }}</th>
                        <th class="px-5 py-3.5 text-start hidden md:table-cell">{{ $t('الحالة','Statut','Status') }}</th>
                        <th class="px-5 py-3.5 text-start hidden lg:table-cell">{{ $t('آخر دخول','Dernière connexion','Last Login') }}</th>
                        <th class="px-5 py-3.5 text-end">{{ $t('الإجراءات','Actions','Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($users as $user)
                        @php
                            $roleName = $user->roles->first()?->name ?? 'USER';
                            [$rbg, $rlabel] = $roleBadge[$roleName] ?? ['bg-slate-100 text-slate-600 border-slate-200', $roleName];
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition group">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-xs font-black shrink-0 shadow-sm">
                                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <button wire:click="openDrawer({{ $user->id }})" class="text-sm font-black text-slate-900 dark:text-slate-100 hover:text-blue-600 text-start truncate block max-w-[180px]">
                                            {{ $user->name }}
                                        </button>
                                        <span class="text-xs font-medium text-slate-400 truncate block max-w-[180px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-black border {{ $rbg }}">{{ $rlabel }}</span>
                            </td>

                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($user->is_active)
                                    <span class="flex items-center gap-1.5 text-[11px] font-black text-emerald-600">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        {{ $t('نشط','Actif','Active') }}
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-[11px] font-black text-rose-500">
                                        <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                                        {{ $t('معطل','Désactivé','Inactive') }}
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5 hidden lg:table-cell text-xs font-medium text-slate-400">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '—' }}
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="toggleScanQrPermission({{ $user->id }})"
                                            title="{{ $t('منح/إلغاء صلاحية مسح QR','Activer/Désactiver scanner QR','Toggle QR scan permission') }}"
                                            class="p-1.5 rounded-lg {{ $user->can_scan_qr ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-400' }} hover:bg-emerald-200 transition font-bold text-[10px] flex items-center gap-1 shrink-0">
                                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                        <span>{{ $user->can_scan_qr
                                            ? $t('ماسح مفعّل','Scanner actif','Scanner ON')
                                            : $t('تفعيل الماسح','Activer scanner','Enable Scanner') }}</span>
                                    </button>

                                    <button wire:click="openRoleModal({{ $user->id }})"
                                            title="{{ $t('تغيير الدور','Changer le rôle','Change Role') }}"
                                            class="p-1.5 rounded-lg hover:bg-amber-50 text-slate-400 hover:text-amber-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                                    </button>

                                    <button wire:click="toggleActive({{ $user->id }})"
                                            title="{{ $user->is_active ? $t('تعطيل','Désactiver','Deactivate') : $t('تفعيل','Activer','Activate') }}"
                                            class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 transition">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </button>

                                    <button wire:click="confirmDelete({{ $user->id }})"
                                            title="{{ $t('حذف','Supprimer','Delete') }}"
                                            class="p-1.5 rounded-lg hover:bg-rose-50 text-slate-400 hover:text-rose-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                                {{ $t('لا توجد نتائج مطابقة','Aucun résultat trouvé','No results found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- ════ CREATE USER MODAL ════ --}}
    @if($createModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-base font-black text-slate-900">
                        {{ $t('إنشاء حساب وتوليد بيانات الدخول','Créer un compte','Create New Account') }}
                    </h3>
                    <button wire:click="$set('createModalOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">{{ $t('الاسم الكامل / الجهة *','Nom complet / Entité *','Full Name / Entity *') }}</label>
                        <input wire:model="create_name" type="text"
                               placeholder="{{ $t('مثال: مسؤول الوفد الجزائري','Ex: Admin Délégation Algérie','Ex: Algerian Delegation Admin') }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">{{ $t('البريد الإلكتروني الرسمي *','Email officiel *','Official Email *') }}</label>
                        <input wire:model="create_email" type="email" placeholder="official@worldskills.dz"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">{{ $t('نوع الحساب والصلاحية *','Type de compte *','Account Type *') }}</label>
                        <select wire:model="create_role" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            <option value="COUNTRY_ADMIN">{{ $t('مسؤول وفد دولة','Admin Délégation Pays','Country Admin') }}</option>
                            <option value="JUDGE">{{ $t('حكم / خبير تقييم','Juge / Expert','Judge / Expert') }}</option>
                            <option value="MEDIA_MANAGER">{{ $t('صحافة وإعلام','Presse & Média','Media & Press') }}</option>
                            <option value="ORGANIZATION_ADMIN">{{ $t('مسؤول مؤسسة تكوينية','Admin Établissement','Organization Admin') }}</option>
                            <option value="EXECUTIVE_VIEWER">{{ $t('مراقب وزاري','Observateur Exécutif','Executive Viewer') }}</option>
                            <option value="PARTICIPANT">{{ $t('متنافس مشارك','Compétiteur','Participant') }}</option>
                        </select>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-slate-700 font-bold">{{ $t('كلمة السر *','Mot de passe *','Password *') }}</label>
                            <button type="button" wire:click="generateNewPassword" class="text-[10px] text-blue-600 hover:underline font-bold">
                                {{ $t('توليد كلمة سر عشوائية','Générer aléatoirement','Generate Random') }}
                            </button>
                        </div>
                        <input wire:model="create_password" type="text"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-mono font-bold text-center text-sm tracking-wider">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button wire:click="$set('createModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ $t('إلغاء','Annuler','Cancel') }}
                    </button>
                    <button wire:click="saveUser" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">
                        {{ $t('حفظ وإنشاء الحساب','Enregistrer','Save & Create') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
