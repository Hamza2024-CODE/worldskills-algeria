<!-- Universal PWA Service Worker Registration & Installation System (WSAP V8.4 - Clean Vector Icons) -->
<div x-data="{
    deferredPrompt: null,
    showBanner: false,
    showGuideModal: false,
    isIOS: false,
    isStandalone: false,
    init() {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA Active:', reg.scope))
                    .catch(err => console.warn('PWA error:', err));
            });
        }

        this.isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (this.isStandalone) {
            return;
        }

        const ua = window.navigator.userAgent || '';
        this.isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            if (!localStorage.getItem('wsap_pwa_dismissed')) {
                this.showBanner = true;
            }
        });

        if (!localStorage.getItem('wsap_pwa_dismissed')) {
            this.showBanner = true;
        }

        window.addEventListener('open-pwa-installer', () => {
            this.installApp();
        });
    },
    installApp() {
        if (this.deferredPrompt) {
            this.deferredPrompt.prompt();
            this.deferredPrompt.userChoice.then((result) => {
                if (result.outcome === 'accepted') {
                    this.showBanner = false;
                }
                this.deferredPrompt = null;
            });
        } else {
            this.showGuideModal = true;
        }
    },
    dismissBanner() {
        this.showBanner = false;
        localStorage.setItem('wsap_pwa_dismissed', 'true');
    }
}" x-init="init()" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Bottom Floating Install Banner -->
    <div x-show="showBanner" 
         x-transition:enter="transition ease-out duration-500 transform" 
         x-transition:enter-start="translate-y-full opacity-0" 
         x-transition:enter-end="translate-y-0 opacity-100" 
         x-transition:leave="transition ease-in duration-300 transform" 
         x-transition:leave-start="translate-y-0 opacity-100" 
         x-transition:leave-end="translate-y-full opacity-0" 
         class="fixed bottom-20 md:bottom-6 start-4 end-4 sm:start-auto sm:end-6 sm:max-w-md z-50 print:hidden select-none" 
         x-cloak>

        <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white p-4.5 rounded-3xl shadow-2xl border border-white/20 backdrop-blur-xl relative overflow-hidden">
            <div class="absolute -top-12 -right-12 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white p-1.5 shadow-md border border-white/30 shrink-0 flex items-center justify-center">
                        <img src="/icon-192.png" alt="WorldSkills App" class="w-full h-full object-contain rounded-xl">
                    </div>
                    <div class="space-y-0.5">
                        <h4 class="text-xs sm:text-sm font-black text-white leading-tight flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Installer l\'Application Mobile' : (app()->getLocale() === 'en' ? 'Install Native Mobile App' : 'تثبيت تطبيق أولمبياد المهن') }}</span>
                        </h4>
                        <p class="text-[10px] text-blue-100 font-bold leading-tight">
                            <span>{{ app()->getLocale() === 'fr' ? 'Accès rapide, hors-ligne et قارئ الـ QR' : (app()->getLocale() === 'en' ? 'Fast offline access & QR scanner' : 'تطبيق هاتف سريع للوصول المباشر والإشعارات') }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" @click="installApp()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs shadow-lg transition transform active:scale-95 whitespace-nowrap flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Installer' : (app()->getLocale() === 'en' ? 'Install' : 'تثبيت الآن') }}</span>
                    </button>

                    <button type="button" @click="dismissBanner()" class="p-1.5 rounded-full text-slate-300 hover:text-white hover:bg-white/10 transition" title="إغلاق">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Step-by-Step Installation Guide Modal (Clean Icons Only) -->
    <div x-show="showGuideModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4" style="display: none;" x-cloak>
        <div @click.outside="showGuideModal = false" class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 text-slate-900 space-y-6 relative overflow-hidden">
            
            <button type="button" @click="showGuideModal = false" class="absolute top-4 end-4 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="text-center space-y-3">
                <div class="w-16 h-16 rounded-3xl bg-brand-50 p-2 shadow-inner border border-brand-100 mx-auto flex items-center justify-center">
                    <img src="/icon-192.png" alt="WorldSkills App Icon" class="w-full h-full object-contain rounded-2xl">
                </div>
                <h3 class="text-lg font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Comment installer l\'application PWA' : (app()->getLocale() === 'en' ? 'How to install WorldSkills App' : 'طريقة تثبيت تطبيق أولمبياد المهن') }}
                </h3>
                <p class="text-xs text-slate-500 font-medium">
                    <template x-if="isIOS">
                        <span>{{ app()->getLocale() === 'fr' ? 'Sur iPhone & iPad (Safari) :' : (app()->getLocale() === 'en' ? 'On iPhone & iPad (Safari):' : 'خطوات التثبيت لأجهزة iPhone و iPad في متصفح Safari:') }}</span>
                    </template>
                    <template x-if="!isIOS">
                        <span>{{ app()->getLocale() === 'fr' ? 'Sur Android ou Ordinateur :' : (app()->getLocale() === 'en' ? 'On Android or Computer:' : 'خطوات التثبيت لأجهزة أندرويد والكمبيوتر:') }}</span>
                    </template>
                </p>
            </div>

            <!-- iOS Instructions (Clean SVG Icons) -->
            <template x-if="isIOS">
                <div class="space-y-3 text-xs font-bold text-slate-700 bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">1</span>
                        <div class="flex items-center gap-1.5">
                            <span>{{ app()->getLocale() === 'fr' ? 'Appuyez sur le bouton Partager en bas de Safari' : (app()->getLocale() === 'en' ? 'Tap the Share button at the bottom of Safari' : 'اضغط على زر المشاركة أسفل شاشة Safari') }}</span>
                            <svg class="w-4 h-4 text-brand-500 inline shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">2</span>
                        <div class="flex items-center gap-1.5">
                            <span>{{ app()->getLocale() === 'fr' ? 'Sélectionnez "Sur l\'écran d\'accueil"' : (app()->getLocale() === 'en' ? 'Tap "Add to Home Screen"' : 'اختر "إضافة إلى الشاشة الرئيسية"') }}</span>
                            <svg class="w-4 h-4 text-brand-500 inline shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">3</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Appuyez sur "Ajouter" en haut à droite' : (app()->getLocale() === 'en' ? 'Tap "Add" in the top right corner' : 'اضغط "إضافة" في الأعلى لإتمام التثبيت') }}</span>
                    </div>
                </div>
            </template>

            <!-- Android / Desktop Instructions -->
            <template x-if="!isIOS">
                <div class="space-y-3 text-xs font-bold text-slate-700 bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">1</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Ouvrez le menu du navigateur en haut' : (app()->getLocale() === 'en' ? 'Open browser menu at top' : 'اضغط قائمة المتصفح في الأعلى') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">2</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Sélectionnez "Installer l\'application" ou "Ajouter à l\'écran d\'accueil"' : (app()->getLocale() === 'en' ? 'Select "Install App" or "Add to Home Screen"' : 'اختر "تثبيت التطبيق" أو "إضافة إلى الشاشة الرئيسية"') }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-xl bg-brand-500 text-white flex items-center justify-center shrink-0 font-black">3</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Confirmez l\'installation pour l\'ouvrir comme application native' : (app()->getLocale() === 'en' ? 'Confirm to launch as native app' : 'أكد التثبيت ليعمل التطبيق مباشرة بالشاشة الرئيسية') }}</span>
                    </div>
                </div>
            </template>

            <button type="button" @click="showGuideModal = false" class="w-full py-3.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-lg transition">
                {{ app()->getLocale() === 'fr' ? 'Fermer' : (app()->getLocale() === 'en' ? 'Close' : 'فهمت، حسناً') }}
            </button>
        </div>
    </div>
</div>
