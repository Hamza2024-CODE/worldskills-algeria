<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- HEADER --}}
        <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-[#06205C] text-white flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-[#06205C]">مركز التنبيهات والإشعارات الفورية</h1>
                    <p class="text-xs text-slate-500 font-medium">
                        تنبيهات الوجبات والمطاعم، السكن والإقامة، الاجتماعات التقنية ومواعيد المسابقات.
                    </p>
                </div>
            </div>

            @if($unreadCount > 0)
            <button wire:click="markAllRead" class="px-4 py-2 rounded-xl bg-brand-50 text-brand-700 hover:bg-brand-100 font-black text-xs transition border border-brand-200 shadow-2xs">
                تحديد الكل كأنها قُرئت ({{ $unreadCount }})
            </button>
            @endif
        </div>

        <!-- PWA Web Push Notification Subscription Banner -->
        <div x-data="{ 
            pushSupported: ('serviceWorker' in navigator && 'PushManager' in window),
            subscribed: false,
            loading: false,
            init() {
                if (this.pushSupported && Notification.permission === 'granted') {
                    this.subscribed = true;
                }
            },
            async subscribePush() {
                if (!this.pushSupported) return;
                this.loading = true;
                try {
                    const perm = await Notification.requestPermission();
                    if (perm === 'granted') {
                        const reg = await navigator.serviceWorker.ready;
                        this.subscribed = true;
                        alert('{{ app()->getLocale() === 'fr' ? 'Notifications Push PWA activées avec succès !' : (app()->getLocale() === 'en' ? 'PWA Push Notifications successfully enabled!' : 'تم تفعيل شبكة التنبيهات الفورية الفائقة PWA بنجاح على هذا الجهاز!') }}');
                    }
                } catch(e) {
                    console.error('Push error:', e);
                } finally {
                    this.loading = false;
                }
            }
        }" class="bg-gradient-to-r from-[#06205C] via-blue-900 to-indigo-900 text-white p-6 rounded-3xl shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border border-blue-500/30">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-xs font-black text-emerald-400 uppercase tracking-widest">
                        <x-ws.icon name="bolt" class="w-3.5 h-3.5 inline-block me-1 text-amber-500" /> {{ app()->getLocale() === 'fr' ? 'Réseau Push PWA Direct' : (app()->getLocale() === 'en' ? 'PWA Direct Push Network' : 'شبكة التنبيهات الفورية اللحظية (PWA Push)') }}
                    </span>
                </div>
                <h3 class="text-base font-black">
                    {{ app()->getLocale() === 'fr' ? 'Recevez les notifications d\'urgence et de résultats sur votre téléphone' : (app()->getLocale() === 'en' ? 'Receive Instant Results & Urgent Alerts on Your Mobile' : 'استقبل تنبيهات التصفيات والنتائج ومواعيد الورش فوراً على هاتفك المحمول') }}
                </h3>
                <p class="text-xs text-blue-200 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Inscrivez votre navigateur au système de notifications PWA en un clic.' : (app()->getLocale() === 'en' ? 'Subscribe your browser to PWA push notifications in one click.' : 'تفعيل الإشعارات الفورية اللحظية للمنافسات والاجتماعات التقنية بنقرة واحدة.') }}
                </p>
            </div>

            <button @click="subscribePush()" 
                    :disabled="subscribed || loading"
                    class="px-5 py-3 rounded-2xl font-black text-xs transition shadow-lg shrink-0 flex items-center gap-2"
                    :class="subscribed ? 'bg-emerald-500 text-white' : 'bg-brand-500 hover:bg-brand-600 text-white'">
                <template x-if="!subscribed && !loading">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Activer Push PWA' : (app()->getLocale() === 'en' ? 'Enable Push PWA' : 'تفعيل التنبيهات الفورية') }}</span>
                    </span>
                </template>
                <template x-if="subscribed">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Push PWA Activé' : (app()->getLocale() === 'en' ? 'Push PWA Active' : 'التنبيهات الفورية مفعلة') }}</span>
                    </span>
                </template>
            </button>
        </div>

        {{-- TABS FILTER --}}
        <div class="flex items-center gap-2 border-b border-slate-200 pb-1">
            <button wire:click="$set('filter', 'all')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ $filter === 'all' ? 'bg-[#06205C] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                جميع الإشعارات
            </button>
            <button wire:click="$set('filter', 'unread')" class="px-4 py-2 rounded-xl text-xs font-black transition flex items-center gap-1.5 {{ $filter === 'unread' ? 'bg-[#06205C] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                <span>غير مقروءة</span>
                @if($unreadCount > 0)
                <span class="px-2 py-0.5 rounded-full bg-rose-500 text-white text-[10px] font-black">{{ $unreadCount }}</span>
                @endif
            </button>
            <button wire:click="$set('filter', 'read')" class="px-4 py-2 rounded-xl text-xs font-black transition {{ $filter === 'read' ? 'bg-[#06205C] text-white shadow-sm' : 'bg-white text-slate-600 hover:bg-slate-100' }}">
                المقروءة
            </button>
        </div>

        {{-- NOTIFICATIONS INBOX LIST --}}
        <div class="space-y-3">
            @forelse($userNotifications as $un)
                @php
                    $n = $un->notification;
                    $locale = app()->getLocale();
                    $title = $n?->getLocalizedTitle($locale);
                    $body = $n?->getLocalizedBody($locale);
                    $isUnread = in_array($un->status, ['PENDING', 'DELIVERED']);
                    $badgeClass = match($n?->type) {
                        'MEAL'              => 'bg-amber-100 text-amber-800 border-amber-300',
                        'TECHNICAL_MEETING' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                        'ACCOMMODATION'      => 'bg-teal-100 text-teal-800 border-teal-300',
                        'COMPETITION'        => 'bg-purple-100 text-purple-800 border-purple-300',
                        'URGENT'             => 'bg-rose-100 text-rose-800 border-rose-300',
                        default              => 'bg-slate-100 text-slate-800 border-slate-300',
                    };
                @endphp
                <div wire:click="openNotification({{ $un->id }})" class="bg-white p-5 rounded-3xl border transition cursor-pointer hover:shadow-md relative overflow-hidden group {{ $isUnread ? 'border-brand-500 shadow-xs ring-1 ring-brand-500/30' : 'border-slate-200/80 opacity-90' }}">
                    @if($isUnread)
                    <div class="absolute top-0 right-0 w-3 h-3 bg-brand-500 rounded-bl-xl"></div>
                    @endif

                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border font-mono {{ $badgeClass }}">
                                    {{ $n?->type }}
                                </span>
                                <h3 class="font-black text-[#06205C] text-sm group-hover:text-brand-600 transition">
                                    {{ $title }}
                                </h3>
                                @if($n?->priority === 'URGENT')
                                <span class="px-2 py-0.5 rounded bg-rose-500 text-white text-[9px] font-black animate-pulse">
                                    URGENT <x-ws.icon name="exclamation-triangle" class="w-3.5 h-3.5 text-rose-500 inline-block" />
                                </span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                {{ $body }}
                            </p>

                            <div class="flex items-center gap-4 text-[10px] text-slate-400 font-mono pt-1">
                                <span class="inline-flex items-center gap-1"><x-ws.icon name="clock" class="w-3 h-3 text-slate-400" /> {{ $un->created_at->diffForHumans() }}</span>
                                @if($un->read_at)
                                <span class="text-emerald-600 font-bold inline-flex items-center gap-1"><x-ws.icon name="check" class="w-3 h-3" /> قُرئت في {{ $un->read_at->format('H:i') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="shrink-0 pt-1">
                            <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-[#06205C] group-hover:text-white text-slate-500 flex items-center justify-center transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 rounded-3xl border border-dashed border-slate-300 text-center space-y-2">
                    <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <p class="font-black text-slate-600 text-sm">لا توجد إشعارات حالياً</p>
                </div>
            @endforelse
        </div>

        @if($userNotifications->hasPages())
            <div class="px-5 py-4 bg-white rounded-2xl border border-slate-200">{{ $userNotifications->links() }}</div>
        @endif

    </div>
</div>
