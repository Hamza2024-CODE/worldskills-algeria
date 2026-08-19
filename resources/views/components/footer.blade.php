<footer class="bg-[#020A24] text-white border-t border-slate-800 py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-slate-800">
            
            <!-- Col 1: Official Single Logo & Summary -->
            @php
                $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
            @endphp
            <div class="space-y-4">
                <div class="flex items-center">
                    <img src="{{ $logoUrl }}" alt="WorldSkills Logo" class="h-12 sm:h-16 w-auto object-contain brightness-0 invert filter drop-shadow-md">
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    {{ app()->getLocale() === 'fr' ? 'Rassemblement des délégations nationales et internationales au Centre des Conventions Mohamed Benahmed à Oran.' : (app()->getLocale() === 'en' ? 'Gathering of national and international delegations at Mohamed Benahmed Convention Center in Oran.' : 'تجمع الوفود الوطنية والدولية بمركز المؤتمرات محمد بن أحمد بمدينة وهران.') }}
                </p>
            </div>

            <!-- Col 2: Competition Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ __('messages.competition') }}</h4>
                <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                    <li><a href="{{ route('skills') }}" class="hover:text-brand-sky transition">{{ __('messages.skills') }}</a></li>
                    <li><a href="{{ route('schedule') }}" class="hover:text-brand-sky transition">{{ __('messages.schedule') }}</a></li>
                    <li><a href="{{ route('results') }}" class="hover:text-brand-sky transition">{{ __('messages.results') }}</a></li>
                    <li><a href="{{ route('events') }}" class="hover:text-brand-sky transition">{{ __('messages.events') }}</a></li>
                    <li><a href="{{ route('live-tv') }}" target="_blank" class="text-rose-400 hover:text-rose-300 font-bold transition flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500 animate-ping inline-block"></span><span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span></a></li>
                </ul>
            </div>

            <!-- Col 3: Quick Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ __('messages.guide') }}</h4>
                <ul class="space-y-2.5 text-xs text-slate-400 font-medium">
                    <li><a href="{{ route('guide') }}" class="hover:text-brand-sky transition">{{ __('messages.guide') }}</a></li>
                    <li><a href="{{ route('regulations') }}" class="hover:text-brand-sky transition">{{ __('messages.regulations') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-brand-sky transition">{{ __('messages.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-brand-sky transition">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter & Socials -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-2">
                    {{ app()->getLocale() === 'fr' ? 'Abonnez-vous à notre newsletter' : (app()->getLocale() === 'en' ? 'Subscribe to our newsletter' : 'اشترك في نشرتنا الإخبارية') }}
                </h4>
                <div class="flex items-center gap-2 bg-slate-900/80 p-1.5 rounded-xl border border-slate-800">
                    <input type="email" placeholder="{{ app()->getLocale() === 'fr' ? 'Entrez votre email...' : (app()->getLocale() === 'en' ? 'Enter your email...' : 'أدخل بريدك الإلكتروني') }}" class="w-full bg-transparent px-3 text-xs text-white placeholder-slate-500 focus:outline-none">
                    <button class="px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs transition">
                        {{ app()->getLocale() === 'fr' ? 'S\'abonner' : (app()->getLocale() === 'en' ? 'Subscribe' : 'اشترك') }}
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 text-[11px] text-slate-500 font-medium">
            <p>© 2026 WorldSkills Algeria. {{ app()->getLocale() === 'fr' ? 'Tous droits réservés.' : (app()->getLocale() === 'en' ? 'All rights reserved.' : 'جميع الحقوق محفوظة.') }}</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-slate-400">
                    {{ app()->getLocale() === 'fr' ? 'Politique de confidentialité' : (app()->getLocale() === 'en' ? 'Privacy Policy' : 'سياسة الخصوصية') }}
                </a>
                <span>|</span>
                <a href="{{ route('terms') }}" class="hover:text-slate-400">
                    {{ app()->getLocale() === 'fr' ? 'Conditions d\'utilisation' : (app()->getLocale() === 'en' ? 'Terms of Use' : 'شروط الاستخدام') }}
                </a>
            </div>
        </div>
    </div>
</footer>
