<footer class="relative text-white border-t border-slate-800/80 py-12 mt-16 overflow-hidden">
    
    <!-- Full-Bleed Cover Photo Background Layer across entire Footer -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden bg-[#020A24]">
        <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=1600&auto=format&fit=crop" 
             alt="WorldSkills Algeria Oran Venue" 
             class="w-full h-full object-cover object-center opacity-15 filter brightness-50 contrast-125 mix-blend-luminosity">
        <!-- Deep Dark Gradient Layer for 100% High-Contrast Text Legibility -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#020A24] via-[#020A24]/90 to-[#01071E]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-slate-800/80">
            
            <!-- Col 1: Official Single Logo & Summary -->
            @php
                $siteLogo = app(\App\Services\SettingsEngine::class)->get('site_logo', '/logo.svg');
                $logoUrl = str_starts_with($siteLogo, 'http') ? $siteLogo : asset($siteLogo);
            @endphp
            <div class="space-y-4">
                <div class="flex items-center">
                    <img src="{{ $logoUrl }}" alt="WorldSkills Logo" class="h-12 sm:h-16 w-auto object-contain brightness-0 invert filter drop-shadow-md">
                </div>
                <p class="text-xs text-slate-200 font-semibold leading-relaxed font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Rassemblement des délégations nationales et internationales au Centre des Conventions Mohamed Benahmed à Oran.' : (app()->getLocale() === 'en' ? 'Gathering of national and international delegations at Mohamed Benahmed Convention Center in Oran.' : 'تجمع الوفود الوطنية والدولية بمركز المؤتمرات محمد بن أحمد بمدينة وهران.') }}
                </p>
                <div class="inline-flex items-center gap-1.5 text-[11px] font-bold text-brand-400 bg-white/5 px-3 py-1.5 rounded-full border border-white/10 backdrop-blur-md">
                    <svg class="w-3.5 h-3.5 text-brand-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Centre des Conventions - Oran' : (app()->getLocale() === 'en' ? 'Convention Center - Oran' : 'مركز المؤتمرات محمد بن أحمد - وهران') }}</span>
                </div>
            </div>

            <!-- Col 2: Competition Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ __('messages.competition') }}</h4>
                <ul class="space-y-2.5 text-xs text-slate-200 font-semibold font-medium">
                    <li><a href="{{ route('skills') }}" class="hover:text-brand-sky transition">{{ __('messages.skills') }}</a></li>
                    <li><a href="{{ route('schedule') }}" class="hover:text-brand-sky transition">{{ __('messages.schedule') }}</a></li>
                    <li><a href="{{ route('results') }}" class="hover:text-brand-sky transition">{{ __('messages.results') }}</a></li>
                    <li><a href="{{ route('events') }}" class="hover:text-brand-sky transition">{{ __('messages.events') }}</a></li>
                    <li><a href="https://africaskills-policyforum.worldskills.dz/" target="_blank" class="text-amber-400 hover:text-amber-300 font-bold transition flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg><span>{{ app()->getLocale() === 'fr' ? 'Forum Politique 2026' : (app()->getLocale() === 'en' ? 'Africa Policy Forum 2026' : 'منتدى السياسات الأفريقية 2026') }}</span></a></li>
                    <li><a href="{{ route('live-tv') }}" target="_blank" class="text-rose-400 hover:text-rose-300 font-bold transition flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-rose-500 animate-ping inline-block"></span><span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span></a></li>
                </ul>
            </div>

            <!-- Col 3: Quick Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ __('messages.guide') }}</h4>
                <ul class="space-y-2.5 text-xs text-slate-200 font-semibold font-medium">
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
                <div class="flex items-center gap-2 bg-slate-900/80 p-1.5 rounded-xl border border-slate-800/80 backdrop-blur-md">
                    <input type="email" placeholder="{{ app()->getLocale() === 'fr' ? 'Entrez votre email...' : (app()->getLocale() === 'en' ? 'Enter your email...' : 'أدخل بريدك الإلكتروني') }}" class="w-full bg-transparent px-3 text-xs text-white placeholder-slate-400 focus:outline-none">
                    <button class="px-4 py-2 rounded-lg bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs transition shadow-md">
                        {{ app()->getLocale() === 'fr' ? 'S&apos;abonner' : (app()->getLocale() === 'en' ? 'Subscribe' : 'اشترك') }}
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 text-[11px] text-slate-400 font-medium">
            <p>© 2026 WorldSkills Algeria. {{ app()->getLocale() === 'fr' ? 'Tous droits réservés.' : (app()->getLocale() === 'en' ? 'All rights reserved.' : 'جميع الحقوق محفوظة.') }}</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-slate-200 transition">
                    {{ app()->getLocale() === 'fr' ? 'Politique de confidentialité' : (app()->getLocale() === 'en' ? 'Privacy Policy' : 'سياسة الخصوصية') }}
                </a>
                <span>|</span>
                <a href="{{ route('terms') }}" class="hover:text-slate-200 transition">
                    {{ app()->getLocale() === 'fr' ? 'Conditions d&apos;utilisation' : (app()->getLocale() === 'en' ? 'Terms of Use' : 'شروط الاستخدام') }}
                </a>
            </div>
        </div>
    </div>
</footer>