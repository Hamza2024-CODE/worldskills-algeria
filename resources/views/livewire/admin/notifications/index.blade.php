@php
    $locale = app()->getLocale();
    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };

    $typesMap = [
        'GENERAL'           => ['ar' => 'إعلان عام', 'fr' => 'Annonce Générale', 'en' => 'General Notice', 'bg' => 'bg-slate-100 text-slate-800 border-slate-300 dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600'],
        'MEAL'              => ['ar' => 'الوجبات والمطاعم', 'fr' => 'Restauration', 'en' => 'Catering & Meals', 'bg' => 'bg-amber-100 text-amber-900 border-amber-300 dark:bg-amber-950/60 dark:text-amber-200 dark:border-amber-800'],
        'TECHNICAL_MEETING' => ['ar' => 'اجتماع تقني', 'fr' => 'Réunion Technique', 'en' => 'Technical Meeting', 'bg' => 'bg-indigo-100 text-indigo-900 border-indigo-300 dark:bg-indigo-950/60 dark:text-indigo-200 dark:border-indigo-800'],
        'ACCOMMODATION'      => ['ar' => 'السكن والإقامة', 'fr' => 'Hébergement', 'en' => 'Accommodation', 'bg' => 'bg-teal-100 text-teal-900 border-teal-300 dark:bg-teal-950/60 dark:text-teal-200 dark:border-teal-800'],
        'COMPETITION'        => ['ar' => 'منافسة وورشات', 'fr' => 'Compétition', 'en' => 'Competition', 'bg' => 'bg-purple-100 text-purple-900 border-purple-300 dark:bg-purple-950/60 dark:text-purple-200 dark:border-purple-800'],
        'URGENT'             => ['ar' => 'تنبيه عاجل', 'fr' => 'Alerte Urgente', 'en' => 'Urgent Alert', 'bg' => 'bg-rose-100 text-rose-900 border-rose-300 dark:bg-rose-950/60 dark:text-rose-200 dark:border-rose-800'],
    ];

    $priorityMap = [
        'URGENT' => ['label' => $t('عاجل جداً', 'Très Urgent', 'Urgent'), 'bg' => 'bg-rose-600 text-white'],
        'HIGH'   => ['label' => $t('أولوية مرتفعة', 'Haute Priorité', 'High Priority'), 'bg' => 'bg-amber-500 text-white'],
        'NORMAL' => ['label' => $t('عادي', 'Normale', 'Normal'), 'bg' => 'bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200'],
        'LOW'    => ['label' => $t('منخفض', 'Basse', 'Low'), 'bg' => 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'],
    ];
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BAND --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0 shadow-md">
                <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $t('مركز التنبيهات والتواصل المركزي (Audience Center)', 'Centre de Communication & Notifications', 'Central Targeted Communication Center') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1">
                    {{ $t('إدارة شاملة للتنبيهات الموجهة وتتبع معدل الاستلام والفتح لجميع الكوادر والوفود والمشاركين.', 'Gestion globale des notifications ciblées et suivi du taux d’ouverture.', 'Manage targeted push notifications and track real-time delivery and open rates.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.notifications.create') }}" class="px-5 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white text-xs font-black transition shadow-md flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $t('إنشاء تنبيه جديد (Audience Builder)', 'Créer une Notification', 'Create New Alert') }}</span>
            </a>
        </div>
    </div>

    {{-- FLASH NOTIFICATION --}}
    @if($flashMessage || session('success'))
        @php
            $bgClass = match($flashMessageType) {
                'danger' => 'bg-rose-50 border-rose-200 text-rose-900 dark:bg-rose-950/40 dark:border-rose-900 dark:text-rose-200',
                'warning' => 'bg-amber-50 border-amber-200 text-amber-900 dark:bg-amber-950/40 dark:border-amber-900 dark:text-amber-200',
                default => 'bg-emerald-50 border-emerald-200 text-emerald-900 dark:bg-emerald-950/40 dark:border-emerald-900 dark:text-emerald-200',
            };
        @endphp
        <div class="p-4 rounded-2xl border {{ $bgClass }} text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage ?: session('success') }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="font-black text-xs hover:opacity-75">
                <x-ws.icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
    @endif

    {{-- KPI DASHBOARD CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 gap-3">
        
        {{-- Total Notifications --}}
        <div wire:click="$set('filterStatus', '')" class="cursor-pointer bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1 hover:border-[#06205C] transition">
            <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">{{ $t('إجمالي التنبيهات', 'Total Notifications', 'Total Notifications') }}</span>
            <p class="text-2xl font-black text-[#06205C] dark:text-white">{{ number_format($totalCount) }}</p>
            <span class="text-[10px] font-bold text-slate-500">{{ $t('تنبيه مسجل', 'Enregistrées', 'Registered') }}</span>
        </div>

        {{-- Sent Notifications --}}
        <div wire:click="$set('filterStatus', 'SENT')" class="cursor-pointer bg-emerald-50 dark:bg-emerald-950/40 p-4 rounded-2xl border border-emerald-200/80 dark:border-emerald-900/60 shadow-xs text-center space-y-1 hover:border-emerald-500 transition">
            <span class="text-emerald-700 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider block">{{ $t('تم إرسالها (Sent)', 'Envoyées', 'Sent Alerts') }}</span>
            <p class="text-2xl font-black text-emerald-900 dark:text-emerald-200">{{ number_format($sentCount) }}</p>
            <span class="text-[10px] font-bold text-emerald-700 dark:text-emerald-400">{{ number_format($totalDelivered) }} {{ $t('مستلم', 'reçus', 'delivered') }}</span>
        </div>

        {{-- Scheduled Notifications --}}
        <div wire:click="$set('filterStatus', 'SCHEDULED')" class="cursor-pointer bg-amber-50 dark:bg-amber-950/40 p-4 rounded-2xl border border-amber-200/80 dark:border-amber-900/60 shadow-xs text-center space-y-1 hover:border-amber-500 transition">
            <span class="text-amber-700 dark:text-amber-400 text-[10px] font-black uppercase tracking-wider block">{{ $t('مجدولة (Scheduled)', 'Planifiées', 'Scheduled') }}</span>
            <p class="text-2xl font-black text-amber-900 dark:text-amber-200">{{ number_format($scheduledCount) }}</p>
            <span class="text-[10px] font-bold text-amber-700 dark:text-amber-400">{{ $t('في الانتظار', 'En attente', 'Pending') }}</span>
        </div>

        {{-- Urgent Alerts --}}
        <div wire:click="$set('filterPriority', 'URGENT')" class="cursor-pointer bg-rose-50 dark:bg-rose-950/40 p-4 rounded-2xl border border-rose-200/80 dark:border-rose-900/60 shadow-xs text-center space-y-1 hover:border-rose-500 transition">
            <span class="text-rose-700 dark:text-rose-400 text-[10px] font-black uppercase tracking-wider block">{{ $t('تنبيهات عاجلة', 'Alertes Urgentes', 'Urgent Alerts') }}</span>
            <p class="text-2xl font-black text-rose-900 dark:text-rose-200">{{ number_format($urgentCount) }}</p>
            <span class="text-[10px] font-bold text-rose-700 dark:text-rose-400">{{ $t('أولوية قصوى', 'Haute priorité', 'High priority') }}</span>
        </div>

        {{-- Overall Read Rate --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs text-center space-y-1">
            <span class="text-sky-600 dark:text-sky-400 text-[10px] font-black uppercase tracking-wider block">{{ $t('نسبة الفتح واللقراءة', 'Taux d’Ouverture', 'Open Rate %') }}</span>
            <p class="text-2xl font-black text-slate-900 dark:text-white">{{ $overallReadRate }}%</p>
            <span class="text-[10px] font-bold text-slate-500">{{ $t('متوسط المنصة', 'Moyenne globale', 'Platform avg') }}</span>
        </div>

    </div>

    {{-- FILTER TOOLBAR --}}
    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-3">
        <div class="flex-1 flex flex-col sm:flex-row flex-wrap items-center gap-3">
            {{-- Search --}}
            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search"
                       placeholder="{{ $t('بحث باسم التنبيه أو المحتوى...', 'Rechercher par titre...', 'Search title or body...') }}"
                       class="w-full ps-9 pe-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white focus:bg-white transition">
                <svg class="w-4 h-4 text-slate-400 absolute start-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Type Filter --}}
            <select wire:model.live="filterType" class="w-full sm:w-44 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="">{{ $t('جميع الأنواع', 'Tous les Types', 'All Types') }}</option>
                @foreach($typesMap as $key => $tm)
                    <option value="{{ $key }}">{{ $t($tm['ar'], $tm['fr'], $tm['en']) }}</option>
                @endforeach
            </select>

            {{-- Status Filter --}}
            <select wire:model.live="filterStatus" class="w-full sm:w-40 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="">{{ $t('جميع الحالات', 'Tous Statuts', 'All Statuses') }}</option>
                <option value="SENT">{{ $t('مرسل (Sent)', 'Envoyé', 'Sent') }}</option>
                <option value="SCHEDULED">{{ $t('مجدول (Scheduled)', 'Planifié', 'Scheduled') }}</option>
                <option value="DRAFT">{{ $t('مسودة (Draft)', 'Brouillon', 'Draft') }}</option>
                <option value="CANCELLED">{{ $t('ملغى (Cancelled)', 'Annulé', 'Cancelled') }}</option>
            </select>

            {{-- Priority Filter --}}
            <select wire:model.live="filterPriority" class="w-full sm:w-40 py-2.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="">{{ $t('جميع الأولويات', 'Toutes Priorités', 'All Priorities') }}</option>
                <option value="URGENT">{{ $t('عاجل جداً', 'Urgent', 'Urgent') }}</option>
                <option value="HIGH">{{ $t('مرتفع', 'Haute', 'High') }}</option>
                <option value="NORMAL">{{ $t('عادي', 'Normale', 'Normal') }}</option>
                <option value="LOW">{{ $t('منخفض', 'Basse', 'Low') }}</option>
            </select>
        </div>

        {{-- Per Page --}}
        <div class="flex items-center gap-2 shrink-0">
            <span class="text-xs font-bold text-slate-400">{{ $t('عرض:', 'Afficher:', 'Show:') }}</span>
            <select wire:model.live="perPage" class="py-2 px-3 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    {{-- MAIN TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-black text-[10px]">
                        <th class="p-4 text-start">{{ $t('التنبيه والعنوان', 'Notification & Titre', 'Notification & Title') }}</th>
                        <th class="p-4 text-start">{{ $t('الأولوية والإجراء', 'Priorité & Action', 'Priority & Action') }}</th>
                        <th class="p-4 text-start">{{ $t('الجمهور المستهدف', 'Cible', 'Target Audience') }}</th>
                        <th class="p-4 text-start">{{ $t('نسبة التسليم والفتح', 'Livraison & Lecture', 'Delivery & Read Rate') }}</th>
                        <th class="p-4 text-start">{{ $t('الحالة والتاريخ', 'Statut & Date', 'Status & Date') }}</th>
                        <th class="p-4 text-end">{{ $t('التحكم والإجراءات', 'Actions', 'Actions & Controls') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60 font-bold">
                    @forelse($notifications as $n)
                        @php
                            $stats = $analyticsMap[$n->id] ?? ['total' => 0, 'delivered' => 0, 'read' => 0, 'clicked' => 0, 'read_pct' => 0];
                            $typeInfo = $typesMap[$n->type] ?? $typesMap['GENERAL'];
                            $prioInfo = $priorityMap[$n->priority] ?? $priorityMap['NORMAL'];
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-900/30 transition">
                            
                            {{-- Title & Snippet --}}
                            <td class="p-4 space-y-1 max-w-sm">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border font-mono {{ $typeInfo['bg'] }}">
                                        {{ $t($typeInfo['ar'], $typeInfo['fr'], $typeInfo['en']) }}
                                    </span>
                                    <span class="font-black text-[#06205C] dark:text-white text-xs sm:text-sm">
                                        {{ $n->title_ar }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2">
                                    {{ $n->body_ar }}
                                </p>
                            </td>

                            {{-- Priority & Action --}}
                            <td class="p-4">
                                <div class="space-y-1">
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-black {{ $prioInfo['bg'] }}">
                                        {{ $prioInfo['label'] }}
                                    </span>
                                    @if($n->action_type)
                                        <span class="block text-[10px] font-mono text-amber-600 dark:text-amber-400 font-bold">
                                            {{ $n->action_type }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- Target Audience --}}
                            <td class="p-4 max-w-xs">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($n->targets as $tTarget)
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-bold border border-slate-200 dark:border-slate-600">
                                            {{ $tTarget->target_type }}: {{ $tTarget->target_id }}
                                        </span>
                                    @empty
                                        <span class="text-slate-400 text-[10px] font-bold">{{ $t('جميع المستخدمين المعتمَدين', 'Tous les Utilisateurs', 'All Active Users') }}</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Delivery Analytics --}}
                            <td class="p-4">
                                @if($n->status === 'SENT')
                                    <div class="space-y-1.5 min-w-[120px]">
                                        <div class="flex items-center justify-between text-[11px]">
                                            <span class="font-black text-slate-800 dark:text-slate-200">{{ $stats['read'] }} / {{ $stats['total'] }} {{ $t('تم الفتح', 'lus', 'read') }}</span>
                                            <span class="text-emerald-600 dark:text-emerald-400 font-extrabold">{{ $stats['read_pct'] }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full bg-emerald-500 rounded-full transition-all" style="width: {{ (float)$stats['read_pct'] }}%"></div>
                                        </div>
                                        <span class="text-[10px] text-slate-400 block">{{ $t('نقرات رابط الإجراء:', 'Clics:', 'Clicks:') }} {{ $stats['clicked'] }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400 text-[11px] font-normal">—</span>
                                @endif
                            </td>

                            {{-- Status & Date --}}
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold
                                    {{ $n->status === 'SENT' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-200' : ($n->status === 'SCHEDULED' ? 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-200' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300') }}">
                                    {{ $n->status }}
                                </span>
                                <span class="block text-[10px] text-slate-400 mt-1 font-mono">
                                    {{ $n->created_at->format('Y-m-d H:i') }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="p-4 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if($n->status === 'DRAFT' || $n->status === 'SCHEDULED')
                                        <button wire:click="dispatchNow({{ $n->id }})" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] shadow-2xs transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                            <span>{{ $t('إرسال الآن', 'Envoyer', 'Send Now') }}</span>
                                        </button>
                                    @endif

                                    @if($n->status === 'SCHEDULED')
                                        <button wire:click="cancelNotification({{ $n->id }})" class="px-3 py-1.5 rounded-xl bg-amber-100 text-amber-900 hover:bg-amber-200 font-bold text-[11px] transition">
                                            {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                                        </button>
                                    @endif

                                    <button wire:click="duplicateNotification({{ $n->id }})" title="{{ $t('تكرار كمسودة جديدة', 'Dupliquer', 'Duplicate as Draft') }}" class="p-1.5 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>

                                    <button wire:click="confirmDelete({{ $n->id }}, '{{ $n->title_ar }}')" title="{{ $t('حذف التنبيه', 'Supprimer', 'Delete Alert') }}" class="p-1.5 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 font-bold text-xs">
                                {{ $t('لا توجد تنبيهات مسجلة حالياً تطابق الفلتر المحدد.', 'Aucune notification.', 'No notifications match selected filters.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $notifications->links() }}
        </div>
    </div>

    {{-- DELETE CONFIRMATION MODAL --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 bg-slate-900/70 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-md w-full p-6 space-y-4 shadow-2xl border border-slate-200 dark:border-slate-700 my-auto text-center">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 font-black flex items-center justify-center mx-auto border border-rose-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-black text-rose-600">{{ $t('تأكيد حذف التنبيه من النظام؟', 'Confirmer la suppression ?', 'Confirm deleting notification?') }}</h3>
                <p class="text-xs font-bold text-slate-500">{{ $deletingTitle }}</p>

                <div class="flex items-center justify-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 font-bold text-xs">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                    <button wire:click="deleteNotification" class="px-5 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">{{ $t('حذف نهائي', 'Supprimer', 'Delete') }}</button>
                </div>
            </div>
        </div>
    @endif

</div>
