@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="min-h-screen bg-slate-950 text-white relative overflow-hidden flex flex-col justify-between selection:bg-[#0066FF] selection:text-white"
     x-data="{
         launchDate: new Date('{{ $launchDate }}').getTime(),
         days: '00',
         hours: '00',
         minutes: '00',
         seconds: '00',
         updateTimer() {
             const now = new Date().getTime();
             const diff = this.launchDate - now;
             if (diff > 0) {
                 this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                 this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                 this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                 this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
             } else {
                 this.days = '00'; this.hours = '00'; this.minutes = '00'; this.seconds = '00';
             }
         }
     }"
     x-init="updateTimer(); setInterval(() => updateTimer(), 1000)">

    {{-- Background Animated Lights & Grid --}}
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 -start-32 w-96 h-96 rounded-full bg-[#0066FF]/25 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 -end-32 w-96 h-96 rounded-full bg-amber-500/20 blur-3xl animate-pulse delay-700"></div>
        <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-blue-600/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-10"></div>
    </div>

    {{-- Header Bar (Language Switcher & Admin Portal Link) --}}
    <header class="relative z-20 max-w-7xl mx-auto w-full px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.svg') }}" alt="WorldSkills Algeria" class="h-10 w-auto drop-shadow-lg" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
            <span class="text-xs font-black tracking-wider uppercase text-blue-400 border-s border-white/20 ps-3 hidden sm:inline">
                WorldSkills Algeria
            </span>
        </div>

        <div class="flex items-center gap-3">
            {{-- Language Switcher Dropdown / Buttons --}}
            <div class="flex items-center gap-1 bg-white/10 backdrop-blur-md p-1 rounded-2xl border border-white/15">
                <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'ar' ? 'bg-[#0066FF] text-white shadow' : 'text-slate-300 hover:text-white' }}">عربي</a>
                <a href="{{ route('lang.switch', ['locale' => 'fr']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'fr' ? 'bg-[#0066FF] text-white shadow' : 'text-slate-300 hover:text-white' }}">FR</a>
                <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="px-3 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'en' ? 'bg-[#0066FF] text-white shadow' : 'text-slate-300 hover:text-white' }}">EN</a>
            </div>

            {{-- Special Admin Login Link --}}
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-2xl bg-amber-400 hover:bg-amber-500 text-slate-950 text-xs font-black transition shadow-lg flex items-center gap-2 border border-amber-300/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span>{{ $t('بوابة الإدارة', 'Portail Admin', 'Admin Portal') }}</span>
            </a>
        </div>
    </header>

    {{-- Main Content Section --}}
    <main class="relative z-10 max-w-4xl mx-auto px-6 py-12 text-center space-y-10 my-auto">
        
        {{-- Pulsing Tag --}}
        <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-300 text-xs font-black tracking-wide uppercase backdrop-blur-xl shadow-xl">
            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
            <span>{{ $t('وضع الترقب والتجهيز الرسمي', 'Mode Lancement Officiel', 'Official Launching Mode') }}</span>
        </div>

        {{-- Main Headline & Subtitle --}}
        <div class="space-y-5">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight drop-shadow-2xl bg-gradient-to-r from-white via-slate-100 to-slate-300 bg-clip-text text-transparent">
                {{ $title ?: $t('انتظرونا قريباً — الإطلاق الرسمي لأولمبياد المهن', 'Prochainement — Lancement Officiel WorldSkills', 'Coming Soon — Official WorldSkills Launch') }}
            </h1>
            <p class="text-sm sm:text-base text-slate-300 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                {{ $message ?: $t('المنصة الوطنية لأولمبياد المهن والمهارات الجزائرية في مرحلة التجهيز النهائي لتوفير تجربة استثنائية لكافة المشاركين والخبراء.', 'La plateforme officielle WorldSkills Algeria est en phase finale de préparation pour offrir une expérience exceptionnelle.', 'The official WorldSkills Algeria platform is undergoing final preparations to deliver an extraordinary experience.') }}
            </p>
        </div>

        {{-- Countdown Timer Glassmorphic Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 max-w-2xl mx-auto">
            {{-- Days --}}
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-5 border border-white/20 shadow-2xl flex flex-col items-center justify-center transform hover:scale-105 transition duration-300">
                <span class="text-3xl sm:text-5xl font-black font-mono text-blue-400 drop-shadow" x-text="days">00</span>
                <span class="text-[11px] font-bold text-slate-300 uppercase tracking-widest mt-1">{{ $t('يوم', 'Jours', 'Days') }}</span>
            </div>

            {{-- Hours --}}
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-5 border border-white/20 shadow-2xl flex flex-col items-center justify-center transform hover:scale-105 transition duration-300">
                <span class="text-3xl sm:text-5xl font-black font-mono text-amber-400 drop-shadow" x-text="hours">00</span>
                <span class="text-[11px] font-bold text-slate-300 uppercase tracking-widest mt-1">{{ $t('ساعة', 'Heures', 'Hours') }}</span>
            </div>

            {{-- Minutes --}}
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-5 border border-white/20 shadow-2xl flex flex-col items-center justify-center transform hover:scale-105 transition duration-300">
                <span class="text-3xl sm:text-5xl font-black font-mono text-blue-400 drop-shadow" x-text="minutes">00</span>
                <span class="text-[11px] font-bold text-slate-300 uppercase tracking-widest mt-1">{{ $t('دقيقة', 'Minutes', 'Minutes') }}</span>
            </div>

            {{-- Seconds --}}
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl p-5 border border-white/20 shadow-2xl flex flex-col items-center justify-center transform hover:scale-105 transition duration-300">
                <span class="text-3xl sm:text-5xl font-black font-mono text-emerald-400 drop-shadow" x-text="seconds">00</span>
                <span class="text-[11px] font-bold text-slate-300 uppercase tracking-widest mt-1">{{ $t('ثانية', 'Secondes', 'Seconds') }}</span>
            </div>
        </div>



    </main>

    {{-- Footer --}}
    <footer class="relative z-20 max-w-7xl mx-auto w-full px-6 py-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400 font-bold">
        <p>© {{ date('Y') }} WorldSkills Algeria — {{ $t('جميع الحقوق محفوظة', 'Tous droits réservés', 'All Rights Reserved') }}</p>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-slate-300 hover:text-amber-400 transition">{{ $t('دخول المسؤولين', 'Connexion Admin', 'Admin Login') }}</a>
        </div>
    </footer>
</div>
