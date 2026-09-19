@php
    $locale = app()->getLocale();
    $t = function($ar, $fr, $en) use ($locale) {
        return match($locale) {
            'fr' => $fr,
            'en' => $en,
            default => $ar,
        };
    };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BAND --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0 shadow-md">
                <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-[#06205C] dark:text-white tracking-tight">
                    {{ $t('محرر التنبيهات المتقدم وتحديد الجمهور (Audience Builder)', 'Créateur de Notifications & Ciblage', 'Advanced Notification & Audience Composer') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-1">
                    {{ $t('إنشاء وجدولة التنبيهات مع التحديد الدقيق للوفود، المشاركين، الحكام، الوجبات، والتخصصات.', 'Composition et programmation avancée avec ciblage fin par délégation et rôle.', 'Compose and schedule notifications with precision targeting across roles and delegations.') }}
                </p>
            </div>
        </div>

        <a href="{{ route('admin.notifications.index') }}" class="px-5 py-2.5 rounded-2xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition">
            {{ $t('العودة لقائمة التنبيهات', 'Retour à la liste', 'Back to Notifications') }}
        </a>
    </div>

    {{-- QUICK TEMPLATES BAR --}}
    <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
        <span class="text-xs font-black text-[#06205C] dark:text-amber-400 block uppercase tracking-wider">{{ $t('قوالب التنبيهات السريعة (Quick Templates)', 'Modèles Rapides', 'Quick Presets') }}</span>
        <div class="flex flex-wrap gap-2 pt-1">
            <button wire:click="applyTemplate('MEAL')" type="button" class="px-3.5 py-2 rounded-2xl bg-amber-50 dark:bg-amber-950/40 hover:bg-amber-100 text-amber-900 dark:text-amber-200 border border-amber-200 dark:border-amber-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>{{ $t('تنبيه وجبة مطعم', 'Repas Restaurant', 'Meal Announcement') }}</span>
            </button>
            <button wire:click="applyTemplate('TECHNICAL_MEETING')" type="button" class="px-3.5 py-2 rounded-2xl bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 text-indigo-900 dark:text-indigo-200 border border-indigo-200 dark:border-indigo-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <span>{{ $t('تنبيه اجتماع تقني', 'Réunion Technique', 'Technical Meeting') }}</span>
            </button>
            <button wire:click="applyTemplate('ACCOMMODATION')" type="button" class="px-3.5 py-2 rounded-2xl bg-teal-50 dark:bg-teal-950/40 hover:bg-teal-100 text-teal-900 dark:text-teal-200 border border-teal-200 dark:border-teal-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>{{ $t('تنبيه سكن وإقامة', 'Hébergement', 'Accommodation Alert') }}</span>
            </button>
            <button wire:click="applyTemplate('COMPETITION')" type="button" class="px-3.5 py-2 rounded-2xl bg-purple-50 dark:bg-purple-950/40 hover:bg-purple-100 text-purple-900 dark:text-purple-200 border border-purple-200 dark:border-purple-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                <span>{{ $t('تنبيه مسابقة وجولات', 'Compétition', 'Competition Round') }}</span>
            </button>
            <button wire:click="applyTemplate('URGENT')" type="button" class="px-3.5 py-2 rounded-2xl bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 text-rose-900 dark:text-rose-200 border border-rose-200 dark:border-rose-800 text-xs font-bold transition flex items-center gap-1.5 shadow-2xs">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $t('تنبيه عاجل من الإدارة', 'Alerte Urgente', 'Urgent Management Alert') }}</span>
            </button>
        </div>
    </div>

    <form wire:submit.prevent="saveAndDispatch" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT COL: CONTENT FORM -->
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-5">
                    <h2 class="text-base font-black text-[#06205C] dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3">1. {{ $t('محتوى التنبيه والبيانات الأساسية', 'Contenu de la Notification', 'Notification Content & Details') }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نوع التنبيه (Type) *', 'Type *', 'Notification Type *') }}</label>
                            <select wire:model.live="type" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                                <option value="GENERAL">GENERAL (إعلان عام)</option>
                                <option value="TECHNICAL_MEETING">TECHNICAL_MEETING (اجتماع تقني)</option>
                                <option value="MEAL">MEAL (وجبة/مطعم)</option>
                                <option value="ACCOMMODATION">ACCOMMODATION (سكن وإقامة)</option>
                                <option value="COMPETITION">COMPETITION (منافسة)</option>
                                <option value="URGENT">URGENT (تنبيه عاجل)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الأولوية (Priority) *', 'Priorité *', 'Priority Level *') }}</label>
                            <select wire:model.live="priority" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                                <option value="LOW">{{ $t('منخفضة (Low)', 'Basse', 'Low') }}</option>
                                <option value="NORMAL">{{ $t('عادية (Normal)', 'Normale', 'Normal') }}</option>
                                <option value="HIGH">{{ $t('مرتفعة (High)', 'Haute', 'High') }}</option>
                                <option value="URGENT">{{ $t('قصوى وعاجلة (Urgent)', 'Urgent', 'Urgent') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('العنوان بالعربية *', 'Titre (AR) *', 'Title (AR) *') }}</label>
                            <input type="text" wire:model="title_ar" placeholder="{{ $t('عنوان التنبيه باللغة العربية...', 'Titre en arabe...', 'Title in Arabic...') }}" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            @error('title_ar') <span class="text-rose-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نص التنبيه بالعربية *', 'Corps (AR) *', 'Body Message (AR) *') }}</label>
                            <textarea wire:model="body_ar" rows="4" placeholder="{{ $t('نص الرسالة أو التنبيه باللغة العربية...', 'Message en arabe...', 'Notification body message in Arabic...') }}" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white"></textarea>
                            @error('body_ar') <span class="text-rose-600 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
                    <h2 class="text-base font-black text-[#06205C] dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3">2. {{ $t('الجدولة والإجراء المرفق (Optional Dispatch & Link)', 'Planification & Action', 'Scheduling & Action Links') }}</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('نوع الإجراء (Action Type)', 'Type d’action', 'Action Type') }}</label>
                            <input type="text" wire:model="action_type" placeholder="MEAL_SLOT, ACCOMMODATION..." class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('معرف الإجراء (Action ID)', 'ID Action', 'Action Target ID') }}</label>
                            <input type="text" wire:model="action_id" placeholder="123" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('وقت الجدولة (تاريخ الإرسال التلقائي)', 'Date de programmation', 'Scheduled Dispatch DateTime') }}</label>
                            <input type="datetime-local" wire:model="scheduled_at" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <span class="text-[10px] text-slate-400 font-bold mt-1 block">{{ $t('اتركه فارغاً للإرسال الفوري الآن.', 'Laisser vide pour un envoi immédiat.', 'Leave empty for immediate instant dispatch.') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COL: AUDIENCE TARGETING BUILDER -->
            <div class="space-y-6">

                {{-- Live Audience Counter --}}
                <div class="bg-[#06205C] text-white p-6 rounded-3xl shadow-md text-center space-y-2">
                    <span class="text-amber-400 text-[11px] font-black uppercase tracking-wider block">{{ $t('تقدير إجمالي المستهدفين', 'Destinataires Estimés', 'Estimated Target Audience') }}</span>
                    <p class="text-3xl font-black text-white">{{ number_format($estimatedRecipients) }}</p>
                    <span class="text-xs font-bold text-slate-300 block">{{ $t('مستخدم معتمد سيتلقى الإشعار', 'Utilisateurs ciblés', 'active users targeted') }}</span>
                </div>

                {{-- Audience Filter Builder --}}
                <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4 text-xs">
                    <h2 class="text-base font-black text-[#06205C] dark:text-white border-b border-slate-100 dark:border-slate-700 pb-3">3. {{ $t('فلترة الجمهور المستهدف (Audience Builder)', 'Ciblage des Destinataires', 'Audience Builder Filters') }}</h2>

                    {{-- Target Roles --}}
                    <div class="space-y-1.5">
                        <label class="block font-black text-slate-700 dark:text-slate-300">{{ $t('حسب الأدوار والصلاحيات', 'Par Rôles', 'Target Roles') }}</label>
                        <div class="space-y-1 max-h-36 overflow-y-auto p-2 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700">
                            @foreach(['PARTICIPANT' => 'المتنافسون والوفود', 'JUDGE' => 'الحكام والخبراء', 'COUNTRY_ADMIN' => 'رؤساء الوفود', 'STAFF' => 'طاقم التنظيم', 'MEDIA_MANAGER' => 'فريق الإعلام', 'SUPER_ADMIN' => 'المسؤولون الفائقون'] as $rVal => $rLabel)
                                <label class="flex items-center gap-2 font-bold text-slate-700 dark:text-slate-300 cursor-pointer">
                                    <input type="checkbox" wire:model.live="targetRoles" value="{{ $rVal }}" class="w-4 h-4 accent-amber-600 rounded">
                                    <span>{{ $rLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Target Countries --}}
                    <div class="space-y-1.5">
                        <label class="block font-black text-slate-700 dark:text-slate-300">{{ $t('حسب الوفد والدولة', 'Par Pays', 'Target Countries') }}</label>
                        <select wire:model.live="targetCountries" multiple class="w-full p-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 font-bold bg-slate-50 dark:bg-slate-900 text-xs max-h-32">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso3 }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Submit Action --}}
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-700">
                        <button type="submit" class="w-full py-3 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <span>{{ $scheduled_at ? $t('جدولة التنبيه للوقت المحدد', 'Planifier la Notification', 'Schedule Notification') : $t('إرسال التنبيه الآن', 'Envoyer Maintenant', 'Dispatch Notification Now') }}</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </form>

</div>
