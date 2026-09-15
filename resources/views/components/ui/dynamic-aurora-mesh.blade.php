{{-- WorldSkills Algeria 2026 — Dynamic Aurora Ambient Mesh (الخيار 2: أمواج الشفق التقنية العائمة) --}}
{{-- هالات لونية ضبابية عائمة بألوان الهوية الرسمية: الأزرق الملكي، السيان الكهربائي، والذهبي العنبري --}}
<div 
    class="absolute inset-0 z-0 overflow-hidden pointer-events-none select-none" 
    aria-hidden="true"
    x-data="{
        scrollY: 0,
        init() {
            window.addEventListener('scroll', () => {
                this.scrollY = window.pageYOffset || document.documentElement.scrollTop;
            }, { passive: true });
        }
    }"
>
    <style>
        @keyframes wsAuroraMesh1 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                border-radius: 64% 36% 54% 46% / 49% 60% 40% 51%;
            }
            33% {
                transform: translate3d(55px, -45px, 0) scale(1.18) rotate(12deg);
                border-radius: 42% 58% 63% 37% / 61% 39% 61% 39%;
            }
            66% {
                transform: translate3d(-35px, 35px, 0) scale(0.92) rotate(-8deg);
                border-radius: 58% 42% 38% 62% / 44% 56% 44% 56%;
            }
        }

        @keyframes wsAuroraMesh2 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                border-radius: 50% 50% 42% 58% / 54% 46% 54% 46%;
            }
            33% {
                transform: translate3d(-60px, 50px, 0) scale(1.22) rotate(-15deg);
                border-radius: 68% 32% 48% 52% / 38% 62% 38% 62%;
            }
            66% {
                transform: translate3d(45px, -30px, 0) scale(0.95) rotate(10deg);
                border-radius: 38% 62% 58% 42% / 59% 41% 59% 41%;
            }
        }

        @keyframes wsAuroraMesh3 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                border-radius: 59% 41% 65% 35% / 48% 55% 45% 52%;
            }
            50% {
                transform: translate3d(50px, 60px, 0) scale(1.25) rotate(18deg);
                border-radius: 41% 59% 35% 65% / 58% 42% 58% 42%;
            }
        }

        @keyframes wsAuroraMesh4 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                border-radius: 63% 37% 50% 50% / 50% 58% 42% 50%;
            }
            50% {
                transform: translate3d(-40px, -50px, 0) scale(1.15);
                border-radius: 45% 55% 62% 38% / 58% 44% 56% 42%;
            }
        }

        .animate-aurora-mesh-1 {
            animation: wsAuroraMesh1 22s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            will-change: transform, border-radius;
        }

        .animate-aurora-mesh-2 {
            animation: wsAuroraMesh2 28s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            will-change: transform, border-radius;
        }

        .animate-aurora-mesh-3 {
            animation: wsAuroraMesh3 25s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            will-change: transform, border-radius;
        }

        .animate-aurora-mesh-4 {
            animation: wsAuroraMesh4 30s cubic-bezier(0.45, 0.05, 0.55, 0.95) infinite;
            will-change: transform, border-radius;
        }
    </style>

    {{-- Subtle Scroll Parallax Wrapper --}}
    <div 
        class="relative w-full h-full"
        :style="`transform: translate3d(0, ${scrollY * 0.04}px, 0);`"
    >
        {{-- ======================================================== --}}
        {{-- SECTION 1 & 2: Hero & Countdown Ambient Waves (أعلى الصفحة) --}}
        {{-- ======================================================== --}}

        {{-- Top Right: Royal Blue Aurora Bloom --}}
        <div class="absolute -top-10 -right-20 w-[42rem] h-[42rem] bg-gradient-to-br from-[#0052CC]/18 via-[#0088FF]/12 to-transparent blur-[120px] sm:blur-[160px] animate-aurora-mesh-1 opacity-90"></div>

        {{-- Top Left: Electric Cyan Shimmer --}}
        <div class="absolute top-28 -left-28 w-[38rem] h-[38rem] bg-gradient-to-tr from-[#00C4CC]/16 via-[#38BDF8]/12 to-transparent blur-[110px] sm:blur-[150px] animate-aurora-mesh-2 opacity-85"></div>

        {{-- Upper Center Subtle Golden Sunlight Glow (الذهبي العنبري) --}}
        <div class="absolute top-96 left-1/3 w-[32rem] h-[32rem] bg-gradient-to-br from-[#F59E0B]/09 via-[#FBBF24]/06 to-transparent blur-[100px] sm:blur-[140px] animate-aurora-mesh-3 opacity-80"></div>

        {{-- ======================================================== --}}
        {{-- SECTION 3 & 4: Stats & Skills Showcase Ambient Waves (وسط الصفحة) --}}
        {{-- ======================================================== --}}

        {{-- Mid-Right: Golden Amber Warmth behind Skills --}}
        <div class="absolute top-[52rem] -right-24 w-[40rem] h-[40rem] bg-gradient-to-bl from-[#F59E0B]/12 via-[#D97706]/07 to-transparent blur-[120px] sm:blur-[160px] animate-aurora-mesh-3 opacity-85"></div>

        {{-- Mid-Left: Royal Blue Competence Waves --}}
        <div class="absolute top-[75rem] -left-24 w-[44rem] h-[44rem] bg-gradient-to-tr from-[#0052CC]/16 via-[#00A3FF]/10 to-transparent blur-[130px] sm:blur-[170px] animate-aurora-mesh-1 opacity-90"></div>

        {{-- Center Horizon: Electric Cyan Pulse --}}
        <div class="absolute top-[105rem] right-1/4 w-[36rem] h-[36rem] bg-gradient-to-br from-[#00C4CC]/15 via-[#0284C7]/10 to-transparent blur-[110px] sm:blur-[150px] animate-aurora-mesh-2 opacity-85"></div>

        {{-- ======================================================== --}}
        {{-- SECTION 5 & 6: Schedule, Media & African Forum Waves (أسفل الصفحة) --}}
        {{-- ======================================================== --}}

        {{-- Deep African Forum Glow (Electric Cyan & Royal Blue) --}}
        <div class="absolute top-[140rem] -left-20 w-[42rem] h-[42rem] bg-gradient-to-tr from-[#00C4CC]/16 via-[#0052CC]/12 to-transparent blur-[120px] sm:blur-[160px] animate-aurora-mesh-4 opacity-90"></div>

        {{-- Partner Section Warm Accent (Golden Amber & Sapphire) --}}
        <div class="absolute top-[175rem] -right-20 w-[38rem] h-[38rem] bg-gradient-to-bl from-[#F59E0B]/10 via-[#0088FF]/10 to-transparent blur-[110px] sm:blur-[150px] animate-aurora-mesh-3 opacity-80"></div>

        {{-- Footer Horizon Deep Royal Blue Base --}}
        <div class="absolute bottom-10 left-1/3 w-[45rem] h-[35rem] bg-gradient-to-t from-[#0052CC]/15 via-[#00A3FF]/08 to-transparent blur-[130px] sm:blur-[170px] animate-aurora-mesh-1 opacity-90"></div>
    </div>
</div>
