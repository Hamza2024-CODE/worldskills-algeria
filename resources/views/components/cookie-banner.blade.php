<!-- Cookie Consent Banner Component (WSAP V8.4 - No Emojis, Clean Vector Icons) -->
<div x-data="{
    showCookieBanner: false,
    init() {
        if (!localStorage.getItem('wsap_cookie_consent')) {
            setTimeout(() => {
                this.showCookieBanner = true;
            }, 1200);
        }
    },
    acceptAll() {
        localStorage.setItem('wsap_cookie_consent', 'accepted');
        document.cookie = 'wsap_cookie_consent=accepted; path=/; max-age=' + (365 * 86400);
        this.showCookieBanner = false;
    },
    acceptEssentials() {
        localStorage.setItem('wsap_cookie_consent', 'essentials');
        document.cookie = 'wsap_cookie_consent=essentials; path=/; max-age=' + (365 * 86400);
        this.showCookieBanner = false;
    }
}" x-init="init()" x-show="showCookieBanner" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0" class="fixed bottom-20 md:bottom-6 start-4 end-4 md:start-6 md:end-auto md:max-w-xl z-50 print:hidden select-none" x-cloak dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="bg-white/95 backdrop-blur-xl rounded-3xl p-6 shadow-2xl border border-slate-200/90 text-slate-800 relative overflow-hidden">
        
        <!-- Header Glow -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="space-y-4 relative z-10">
            <div class="flex items-start justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-brand-50 border border-brand-100 flex items-center justify-center text-brand-600 shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-black text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Gestion des Cookies et Confidentialité' : (app()->getLocale() === 'en' ? 'Cookies & Privacy Protection' : 'ملفات تعريف الارتباط وحماية البيانات') }}
                        </h4>
                        <span class="text-[10px] font-bold text-slate-400">
                            {{ app()->getLocale() === 'fr' ? 'Loi 18-07 relative à la protection des données' : (app()->getLocale() === 'en' ? 'Algerian Law 18-07 Data Compliance' : 'وفق القانون الجزائري رقم 18-07 لحماية البيانات الشخصية') }}
                        </span>
                    </div>
                </div>

                <button type="button" @click="acceptEssentials()" class="text-slate-400 hover:text-slate-600 transition p-1" title="إغلاق">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Nous utilisons des cookies essentiels pour assurer le bon fonctionnement de la plateforme WorldSkills Algeria, la sécurité des sessions et l\'amélioration de votre expérience.' : (app()->getLocale() === 'en' ? 'We use essential cookies to ensure secure operation of the WorldSkills Algeria platform, account authentication, and user experience enhancement.' : 'تستخدم منصة أولمبياد المهن الجزائرية ملفات تعريف الارتباط الأساسية لضمان عمل المنصة، تأمين الجلسات، وحفظ تفضيلات اللغة والحساب الشخصي.') }}
                <a href="{{ route('privacy') }}" class="text-brand-600 underline font-bold hover:text-brand-700 ms-1">
                    {{ app()->getLocale() === 'fr' ? 'En savoir plus' : (app()->getLocale() === 'en' ? 'Read Privacy Policy' : 'قراءة سياسة الخصوصية') }}
                </a>
            </p>

            <div class="flex flex-wrap items-center justify-end gap-2 pt-1">
                <button type="button" @click="acceptEssentials()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                    {{ app()->getLocale() === 'fr' ? 'Essentiels uniquement' : (app()->getLocale() === 'en' ? 'Essentials Only' : 'الملفات الأساسية فقط') }}
                </button>
                <button type="button" @click="acceptAll()" class="px-5 py-2 rounded-xl bg-gradient-to-r from-[#0052CC] to-[#0066FF] hover:from-[#003999] hover:to-[#0052CC] text-white text-xs font-black shadow-lg shadow-blue-500/20 transition transform hover:-translate-y-0.5 active:scale-95">
                    {{ app()->getLocale() === 'fr' ? 'Accepter Tout' : (app()->getLocale() === 'en' ? 'Accept All' : 'قبول وحفظ الجميع') }}
                </button>
            </div>
        </div>
    </div>
</div>
