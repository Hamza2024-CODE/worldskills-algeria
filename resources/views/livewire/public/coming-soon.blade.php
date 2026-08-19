@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="min-h-screen bg-[#F4F7FC] text-slate-900 relative overflow-hidden flex flex-col justify-between font-sans selection:bg-[#0066FF] selection:text-white"
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

    {{-- Subtle White & Blue Background Glows --}}
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 start-1/2 -translate-x-1/2 w-[800px] h-[400px] rounded-full bg-blue-500/10 blur-[120px]"></div>
        <div class="absolute -bottom-32 -start-32 w-96 h-96 rounded-full bg-blue-400/10 blur-3xl"></div>
    </div>

    {{-- Clean Header Bar (Logo & Language Switcher Only) --}}
    <header class="relative z-20 max-w-7xl mx-auto w-full px-6 py-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.svg') }}" alt="WorldSkills Algeria" class="h-12 w-auto" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
        </div>

        {{-- Language Switcher Only --}}
        <div class="flex items-center gap-1 bg-white shadow-md p-1.5 rounded-2xl border border-slate-200">
            <a href="{{ route('lang.switch', ['locale' => 'ar']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'ar' ? 'bg-[#0066FF] text-white shadow-sm' : 'text-slate-600 hover:text-[#0066FF]' }}">عربي</a>
            <a href="{{ route('lang.switch', ['locale' => 'fr']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'fr' ? 'bg-[#0066FF] text-white shadow-sm' : 'text-slate-600 hover:text-[#0066FF]' }}">FR</a>
            <a href="{{ route('lang.switch', ['locale' => 'en']) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-black transition {{ $locale === 'en' ? 'bg-[#0066FF] text-white shadow-sm' : 'text-slate-600 hover:text-[#0066FF]' }}">EN</a>
        </div>
    </header>

    {{-- Main Content (Title + Countdown Timer Only) --}}
    <main class="relative z-10 max-w-3xl mx-auto px-6 py-12 text-center space-y-12 my-auto">
        
        {{-- Title --}}
        <div class="space-y-4">
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-[#06205C] leading-tight">
                {{ $title ?: $t('انتظرونا قريباً — الإطلاق الرسمي', 'Prochainement — Lancement Officiel', 'Coming Soon — Official Launch') }}
            </h1>
        </div>

        {{-- Clean White & Blue Countdown Timer Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 max-w-2xl mx-auto">
            {{-- Days --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xl flex flex-col items-center justify-center transform hover:-translate-y-1 transition duration-300">
                <span class="text-4xl sm:text-6xl font-black font-mono text-[#0066FF]" x-text="days">00</span>
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest mt-2">{{ $t('يوم', 'Jours', 'Days') }}</span>
            </div>

            {{-- Hours --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xl flex flex-col items-center justify-center transform hover:-translate-y-1 transition duration-300">
                <span class="text-4xl sm:text-6xl font-black font-mono text-[#0066FF]" x-text="hours">00</span>
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest mt-2">{{ $t('ساعة', 'Heures', 'Hours') }}</span>
            </div>

            {{-- Minutes --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xl flex flex-col items-center justify-center transform hover:-translate-y-1 transition duration-300">
                <span class="text-4xl sm:text-6xl font-black font-mono text-[#0066FF]" x-text="minutes">00</span>
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest mt-2">{{ $t('دقيقة', 'Minutes', 'Minutes') }}</span>
            </div>

            {{-- Seconds --}}
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xl flex flex-col items-center justify-center transform hover:-translate-y-1 transition duration-300">
                <span class="text-4xl sm:text-6xl font-black font-mono text-[#0066FF]" x-text="seconds">00</span>
                <span class="text-xs font-black text-slate-500 uppercase tracking-widest mt-2">{{ $t('ثانية', 'Secondes', 'Seconds') }}</span>
            </div>
        </div>

    </main>

    {{-- Clean Footer --}}
    <footer class="relative z-20 max-w-7xl mx-auto w-full px-6 py-6 border-t border-slate-200 flex items-center justify-center text-xs text-slate-500 font-bold">
        <p>© {{ date('Y') }} WorldSkills Algeria — {{ $t('جميع الحقوق محفوظة', 'Tous droits réservés', 'All Rights Reserved') }}</p>
    </footer>

    {{-- PWA Installer Prompt & Cookie Banner --}}
    <x-pwa-installer />
    <x-cookie-banner />
</div>
