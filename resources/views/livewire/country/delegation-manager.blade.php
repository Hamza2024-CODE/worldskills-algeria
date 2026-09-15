<div class="space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950 text-[#0066FF] dark:text-sky-400 flex items-center justify-center font-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-black text-[#06205C] dark:text-white">
                    {{ $country?->getLocalized('name') ?? (app()->getLocale() === 'fr' ? 'Délégation Nationale' : (app()->getLocale() === 'en' ? 'National Delegation' : 'الوفد الوطني')) }} — {{ app()->getLocale() === 'fr' ? 'Gestion des Membres de la Délégation' : (app()->getLocale() === 'en' ? 'Delegation Roster Management' : 'إدارة ومراجعة أعضاء الوفد الرسميين') }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                    {{ app()->getLocale() === 'fr' ? 'Examinez, modifiez, validez ou supprimez les membres de votre délégation.' : (app()->getLocale() === 'en' ? 'Review, edit, approve or remove members of your delegation.' : 'مراجعة بيانات الوفد، الموافقة على المترشحين، تعديل القياسات والمهن، أو حذف الأعضاء.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 self-start sm:self-auto">
            <button wire:click="openAddModal" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Ajouter Membre' : (app()->getLocale() === 'en' ? 'Add Member' : 'إضافة عضو جديد') }}</span>
            </button>
            <a href="{{ route('country.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
                {{ __('messages.back') }}
            </a>
        </div>
    </div>

    <!-- Flash Message Notification -->
    @if($flashMessage ?? null)
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-bold flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 font-bold text-xs"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
        </div>
    @endif

    <!-- Search & Filter Control Bar -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <!-- Search Input -->
        <div class="relative w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="searchQuery" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher nom, passeport...' : (app()->getLocale() === 'en' ? 'Search name, passport...' : 'ابحث بالاسم، رقم الجواز أو البريد...') }}" class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#06205C] dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <!-- Role Filter -->
            <select wire:model.live="selectedRole" class="px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#06205C] dark:text-white">
                <option value="ALL">{{ app()->getLocale() === 'fr' ? 'Tous les Rôles' : (app()->getLocale() === 'en' ? 'All Roles' : 'كل الأدوار والفئات') }}</option>
                <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'متنافس') }}</option>
                <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Expert Technique' : (app()->getLocale() === 'en' ? 'Technical Expert' : 'خبير تحكيم') }}</option>
                <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juge' : (app()->getLocale() === 'en' ? 'Judge' : 'حكم') }}</option>
                <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse' : (app()->getLocale() === 'en' ? 'Press' : 'صحفي / إعلامي') }}</option>
                <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrant' : (app()->getLocale() === 'en' ? 'Supervisor' : 'مؤطر / قائد فريق') }}</option>
                <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'VIP' : (app()->getLocale() === 'en' ? 'VIP' : 'شخصية VIP') }}</option>
                <option value="DELEGATE">DELEGATE — {{ app()->getLocale() === 'fr' ? 'Délégué' : (app()->getLocale() === 'en' ? 'Delegate' : 'مندوب وفد') }}</option>
                <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiel' : (app()->getLocale() === 'en' ? 'Official' : 'رسمي') }}</option>
                <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Support' : (app()->getLocale() === 'en' ? 'Support' : 'طاقم دعم') }}</option>
            </select>

            <!-- Status Filter -->
            <select wire:model.live="selectedStatus" class="px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#06205C] dark:text-white">
                <option value="ALL">{{ app()->getLocale() === 'fr' ? 'Tous les Statuts' : (app()->getLocale() === 'en' ? 'All Statuses' : 'كل الحالات') }}</option>
                <option value="APPROVED">Approved — {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد ومقبول') }}</option>
                <option value="PENDING">Pending — {{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد المراجعة') }}</option>
                <option value="REJECTED">Rejected — {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}</option>
            </select>
        </div>
    </div>

    <!-- Roster Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[#06205C] font-black border-b border-slate-200">
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Nom & Prénom' : (app()->getLocale() === 'en' ? 'Full Name' : 'الاسم واللقب / العضو') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Catégorie / Rôle' : (app()->getLocale() === 'en' ? 'Role / Category' : 'الصفة / الدور') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Discipline' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة التنافسية') }}</th>
                        <th class="text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Document Identité' : (app()->getLocale() === 'en' ? 'Identity Document' : 'وثيقة الهوية (NIN / الجواز)') }}</th>
                        <th class="text-center px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Tailles (Tenue/Chaussures)' : (app()->getLocale() === 'en' ? 'Sizes (Suit/Shoe)' : 'القياسات (بدلة/حذاء)') }}</th>
                        <th class="text-center px-4 py-4">{{ app()->getLocale() === 'fr' ? 'Statut' : (app()->getLocale() === 'en' ? 'Status' : 'حالة الاعتماد') }}</th>
                        <th class="text-center px-6 py-4">{{ app()->getLocale() === 'fr' ? 'Actions' : (app()->getLocale() === 'en' ? 'Actions' : 'الإجراءات والعمليات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($members as $m)
                        <tr class="hover:bg-slate-50/80 transition">

                            <!-- Name & Email -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 text-[#0066FF] font-black flex items-center justify-center text-xs shrink-0 border border-blue-100">
                                        {{ mb_substr($m->first_name, 0, 1) }}{{ mb_substr($m->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 text-xs">{{ $m->full_name }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $m->email ?: ($m->phone ?: '—') }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="px-4 py-4">
                                <span class="px-2.5 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ match($m->member_type) {
                                    'PARTICIPANT' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'EXPERT' => 'bg-purple-50 text-purple-700 border border-purple-200',
                                    'JUDGE' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'PRESS' => 'bg-cyan-50 text-cyan-700 border border-cyan-200',
                                    'SUPERVISOR' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
                                    'VIP' => 'bg-rose-50 text-rose-700 border border-rose-200',
                                    'DELEGATE' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    default => 'bg-slate-100 text-slate-700 border border-slate-200'
                                } }}">
                                    {{ $m->member_type }}
                                </span>
                            </td>

                            <!-- Skill -->
                            <td class="px-4 py-4">
                                @if($m->skill)
                                    <span class="font-bold text-slate-700 text-xs flex items-center gap-1">
                                        <span class="font-mono text-[10px] text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded border border-blue-100">{{ $m->skill->code }}</span>
                                        {{ $m->skill->getLocalized('name') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">—</span>
                                @endif
                            </td>

                            <!-- Identity Document -->
                            <td class="px-4 py-4">
                                <p class="font-mono text-xs font-bold text-slate-700">
                                    {{ $m->passport_number ? 'PASS: ' . $m->passport_number : ($m->nin_number ? 'NIN: ' . $m->nin_number : '—') }}
                                </p>
                                <p class="text-[10px] text-slate-400 capitalize">{{ $m->gender === 'female' ? (app()->getLocale() === 'fr' ? 'Femme' : (app()->getLocale() === 'en' ? 'Female' : 'أنثى')) : (app()->getLocale() === 'fr' ? 'Homme' : (app()->getLocale() === 'en' ? 'Male' : 'ذكر')) }}</p>
                            </td>

                            <!-- Sizing -->
                            <td class="px-4 py-4 text-center">
                                @if($m->suit_size || $m->shoe_size)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-slate-100 text-slate-700 font-mono text-[10px] font-bold">
                                        <span>Suit: {{ $m->suit_size ?: '-' }}</span>
                                        <span>Shoe: {{ $m->shoe_size ?: '-' }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[11px]">—</span>
                                @endif
                            </td>

                            <!-- Status Badge -->
                            <td class="px-4 py-4 text-center">
                                @if($m->status === 'APPROVED')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد ومقبول') }}
                                    </span>
                                @elseif($m->status === 'REJECTED')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-amber-50 text-amber-700 border border-amber-200">
                                        {{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد التثبت') }}
                                    </span>
                                @endif
                            </td>

                            <!-- Action Controls -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <!-- View Details -->
                                    <button wire:click="viewMemberDetails({{ $m->id }})" title="Voir Dossier" class="p-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <!-- Quick Approve -->
                                    @if($m->status !== 'APPROVED')
                                        <button wire:click="approveMember({{ $m->id }})" title="Approuver" class="p-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    @endif

                                    <!-- Quick Reject -->
                                    @if($m->status !== 'REJECTED')
                                        <button wire:click="rejectMember({{ $m->id }})" title="Rejeter" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    @endif

                                    <!-- Edit -->
                                    <button wire:click="editMember({{ $m->id }})" title="Editer" class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>

                                    <!-- Delete -->
                                    <button wire:click="removeMember({{ $m->id }})" wire:confirm="Supprimer ce membre?" title="Supprimer" class="p-1.5 rounded-lg bg-slate-100 hover:bg-rose-100 hover:text-rose-700 text-slate-500 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-xs font-bold text-slate-400">
                                {{ app()->getLocale() === 'fr' ? 'Aucun membre trouvé.' : (app()->getLocale() === 'en' ? 'No members found.' : 'لم يتم العثور على أعضاء مطابقين للبحث أو الفلتر المعتمد.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: ADD MEMBER MODAL -->
    @if($showAddModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Ajouter Membre à la Délégation' : (app()->getLocale() === 'en' ? 'Add Member to Delegation' : 'إضافة عضو جديد للوفد الوطني') }}</h3>
                    <button wire:click="$set('showAddModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <form wire:submit.prevent="addMember" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Prénom *' : (app()->getLocale() === 'en' ? 'First Name *' : 'الاسم الأول *') }}</label>
                            <input type="text" wire:model="firstName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Nom *' : (app()->getLocale() === 'en' ? 'Last Name *' : 'اللقب *') }}</label>
                            <input type="text" wire:model="lastName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Rôle / Catégorie *' : (app()->getLocale() === 'en' ? 'Category / Role *' : 'الصفة / الدور في الوفد *') }}</label>
                            <select wire:model="memberType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="MINISTERIAL_OBSERVER">MINISTERIAL_OBSERVER — {{ app()->getLocale() === 'fr' ? 'Observateur Exécutif / Ministre' : (app()->getLocale() === 'en' ? 'Ministerial Executive Observer' : 'وزير / مراقب تنفيذي') }}</option>
                                <option value="DELEGATION_HEAD">DELEGATION_HEAD — {{ app()->getLocale() === 'fr' ? 'Chef de Délégation' : (app()->getLocale() === 'en' ? 'Head of Delegation' : 'مسؤول الوفد') }}</option>
                                <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'متنافس') }}</option>
                                <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Expert' : (app()->getLocale() === 'en' ? 'Expert' : 'خبير تحكيم') }}</option>
                                <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juge' : (app()->getLocale() === 'en' ? 'Judge' : 'حكم') }}</option>
                                <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse' : (app()->getLocale() === 'en' ? 'Press' : 'صحفي') }}</option>
                                <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrant' : (app()->getLocale() === 'en' ? 'Supervisor' : 'مؤطر') }}</option>
                                <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'VIP' : (app()->getLocale() === 'en' ? 'VIP' : 'شخصية VIP') }}</option>
                                <option value="DELEGATE">DELEGATE — {{ app()->getLocale() === 'fr' ? 'Délégué' : (app()->getLocale() === 'en' ? 'Delegate' : 'مندوب وفد') }}</option>
                                <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiel' : (app()->getLocale() === 'en' ? 'Official' : 'رسمي') }}</option>
                                <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Support' : (app()->getLocale() === 'en' ? 'Support' : 'طاقم دعم') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Métier' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة / التخصص التنافسي') }}</label>
                            <select wire:model="skillId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="">-- {{ app()->getLocale() === 'fr' ? 'Non spécifié' : (app()->getLocale() === 'en' ? 'Not specified' : 'بدون تخصص معين') }} --</option>
                                @foreach($skills as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro de Passeport' : (app()->getLocale() === 'en' ? 'Passport Number' : 'رقم جواز السفر') }}</label>
                            <input type="text" wire:model="passportNumber" placeholder="PASS-123456" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Numéro NIN' : (app()->getLocale() === 'en' ? 'NIN Number' : 'رقم التعريف الوطني (NIN)') }}</label>
                            <input type="text" wire:model="ninNumber" placeholder="10000200..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Genre *' : (app()->getLocale() === 'en' ? 'Gender *' : 'الجنس *') }}</label>
                            <select wire:model="gender" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="male">{{ app()->getLocale() === 'fr' ? 'Homme' : (app()->getLocale() === 'en' ? 'Male' : 'ذكر') }}</option>
                                <option value="female">{{ app()->getLocale() === 'fr' ? 'Femme' : (app()->getLocale() === 'en' ? 'Female' : 'أنثى') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Taille Vêtement' : (app()->getLocale() === 'en' ? 'Suit Size' : 'قياس البدلة الرسمية') }}</label>
                            <input type="text" wire:model="suitSize" placeholder="M / L / XL / 50" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Pointure Chaussures' : (app()->getLocale() === 'en' ? 'Shoe Size' : 'قياس الحذاء') }}</label>
                            <input type="text" wire:model="shoeSize" placeholder="42" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'E-mail' : (app()->getLocale() === 'en' ? 'Email' : 'البريد الإلكتروني') }}</label>
                            <input type="email" wire:model="email" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Téléphone' : (app()->getLocale() === 'en' ? 'Phone' : 'رقم الهاتف') }}</label>
                            <input type="text" wire:model="phone" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" wire:click="$set('showAddModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md">{{ app()->getLocale() === 'fr' ? 'Ajouter Membre' : (app()->getLocale() === 'en' ? 'Add Member' : 'إضافة العضو') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 2: EDIT MEMBER MODAL -->
    @if($showEditModal ?? false)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-2xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Modifier Membre' : (app()->getLocale() === 'en' ? 'Edit Member' : 'تعديل بيانات عضو الوفد') }}</h3>
                    <button wire:click="$set('showEditModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <form wire:submit.prevent="updateMember" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Prénom *' : (app()->getLocale() === 'en' ? 'First Name *' : 'الاسم الأول *') }}</label>
                            <input type="text" wire:model="firstName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Nom *' : (app()->getLocale() === 'en' ? 'Last Name *' : 'اللقب *') }}</label>
                            <input type="text" wire:model="lastName" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Rôle / Catégorie *' : (app()->getLocale() === 'en' ? 'Role / Category *' : 'الصفة / الدور *') }}</label>
                            <select wire:model="memberType" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="PARTICIPANT">PARTICIPANT — {{ app()->getLocale() === 'fr' ? 'Compétiteur' : (app()->getLocale() === 'en' ? 'Competitor' : 'متنافس') }}</option>
                                <option value="EXPERT">EXPERT — {{ app()->getLocale() === 'fr' ? 'Expert' : (app()->getLocale() === 'en' ? 'Expert' : 'خبير تحكيم') }}</option>
                                <option value="JUDGE">JUDGE — {{ app()->getLocale() === 'fr' ? 'Juge' : (app()->getLocale() === 'en' ? 'Judge' : 'حكم') }}</option>
                                <option value="PRESS">PRESS — {{ app()->getLocale() === 'fr' ? 'Presse' : (app()->getLocale() === 'en' ? 'Press' : 'صحفي') }}</option>
                                <option value="SUPERVISOR">SUPERVISOR — {{ app()->getLocale() === 'fr' ? 'Encadrant' : (app()->getLocale() === 'en' ? 'Supervisor' : 'مؤطر') }}</option>
                                <option value="VIP">VIP — {{ app()->getLocale() === 'fr' ? 'VIP' : (app()->getLocale() === 'en' ? 'VIP' : 'شخصية VIP') }}</option>
                                <option value="DELEGATE">DELEGATE — {{ app()->getLocale() === 'fr' ? 'Délégué' : (app()->getLocale() === 'en' ? 'Delegate' : 'مندوب وفد') }}</option>
                                <option value="OFFICIAL">OFFICIAL — {{ app()->getLocale() === 'fr' ? 'Officiel' : (app()->getLocale() === 'en' ? 'Official' : 'رسمي') }}</option>
                                <option value="SUPPORT_STAFF">SUPPORT_STAFF — {{ app()->getLocale() === 'fr' ? 'Support' : (app()->getLocale() === 'en' ? 'Support' : 'طاقم دعم') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Métier' : (app()->getLocale() === 'en' ? 'Skill' : 'المهنة / التخصص') }}</label>
                            <select wire:model="skillId" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="">-- {{ app()->getLocale() === 'fr' ? 'Non spécifié' : (app()->getLocale() === 'en' ? 'Not specified' : 'بدون تخصص معين') }} --</option>
                                @foreach($skills as $sk)
                                    <option value="{{ $sk->id }}">{{ $sk->code }} — {{ $sk->getLocalized('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Statut *' : (app()->getLocale() === 'en' ? 'Status *' : 'حالة الاعتماد *') }}</label>
                            <select wire:model="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                                <option value="APPROVED">Approved — {{ app()->getLocale() === 'fr' ? 'Approuvé' : (app()->getLocale() === 'en' ? 'Approved' : 'معتمد') }}</option>
                                <option value="PENDING">Pending — {{ app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'Pending' : 'قيد المراجعة') }}</option>
                                <option value="REJECTED">Rejected — {{ app()->getLocale() === 'fr' ? 'Rejeté' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوض') }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Taille Vêtement' : (app()->getLocale() === 'en' ? 'Suit Size' : 'قياس البدلة') }}</label>
                            <input type="text" wire:model="suitSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Pointure Chaussures' : (app()->getLocale() === 'en' ? 'Shoe Size' : 'قياس الحذاء') }}</label>
                            <input type="text" wire:model="shoeSize" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'Passeport' : (app()->getLocale() === 'en' ? 'Passport' : 'رقم الجواز') }}</label>
                            <input type="text" wire:model="passportNumber" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">{{ app()->getLocale() === 'fr' ? 'NIN' : (app()->getLocale() === 'en' ? 'NIN' : 'رقم التعريف الوطني (NIN)') }}</label>
                            <input type="text" wire:model="ninNumber" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-mono font-bold">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" wire:click="$set('showEditModal', false)" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Annuler' : (app()->getLocale() === 'en' ? 'Cancel' : 'إلغاء') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs shadow-md">{{ app()->getLocale() === 'fr' ? 'Enregistrer' : (app()->getLocale() === 'en' ? 'Save Changes' : 'حفظ التغييرات') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL 3: VIEW MEMBER DOSSIER MODAL -->
    @if(($showViewModal ?? false) && ($viewingMember ?? null))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white rounded-3xl max-w-xl w-full p-6 space-y-6 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <h3 class="text-base font-black text-[#06205C]">{{ app()->getLocale() === 'fr' ? 'Dossier Membre' : (app()->getLocale() === 'en' ? 'Member Dossier' : 'الملف الموحد لعضو الوفد') }}</h3>
                    <button wire:click="$set('showViewModal', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <div class="w-14 h-14 rounded-2xl bg-[#0066FF] text-white font-black flex items-center justify-center text-lg">
                            {{ mb_substr($viewingMember->first_name, 0, 1) }}{{ mb_substr($viewingMember->last_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-base font-black text-slate-900">{{ $viewingMember->full_name }}</h4>
                            <p class="text-xs text-blue-600 font-bold mt-0.5">{{ $viewingMember->member_type }}</p>
                            <p class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $viewingMember->delegation?->country?->name_ar ?? 'Algeria' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Discipline' : (app()->getLocale() === 'en' ? 'Assigned Skill' : 'المهنة المخصصة') }}</span>
                            <span class="font-bold text-slate-800 text-xs">{{ $viewingMember->skill ? $viewingMember->skill->code . ' - ' . $viewingMember->skill->getLocalized('name') : '—' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Statut' : (app()->getLocale() === 'en' ? 'Status' : 'حالة الاعتماد') }}</span>
                            <span class="font-bold text-xs {{ $viewingMember->status === 'APPROVED' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $viewingMember->status }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Passeport' : (app()->getLocale() === 'en' ? 'Passport' : 'رقم الجواز') }}</span>
                            <span class="font-mono font-bold text-slate-800 text-xs">{{ $viewingMember->passport_number ?: '—' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'NIN' : (app()->getLocale() === 'en' ? 'NIN' : 'رقم التعريف الوطني (NIN)') }}</span>
                            <span class="font-mono font-bold text-slate-800 text-xs">{{ $viewingMember->nin_number ?: '—' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Tailles' : (app()->getLocale() === 'en' ? 'Sizes' : 'قياس البدلة والحذاء') }}</span>
                            <span class="font-bold text-slate-800 text-xs">Suit: {{ $viewingMember->suit_size ?: '-' }} | Shoe: {{ $viewingMember->shoe_size ?: '-' }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-slate-400 block text-[10px] font-bold">{{ app()->getLocale() === 'fr' ? 'Contact' : (app()->getLocale() === 'en' ? 'Contact' : 'البريد والهاتف') }}</span>
                            <span class="font-mono font-bold text-slate-800 text-xs">{{ $viewingMember->email ?: $viewingMember->phone }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button wire:click="$set('showViewModal', false)" class="px-5 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs">{{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'إغلاق') }}</button>
                </div>
            </div>
        </div>
    @endif

</div>
