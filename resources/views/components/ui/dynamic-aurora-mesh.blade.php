{{-- WorldSkills Algeria 2026 — Dynamic Aurora Ambient Mesh (Ultra-Optimized 120Hz Engine) --}}
{{-- هالات لونية ضبابية بألوان الهوية الرسمية، محسنة بنسبة 100% لتعمل بسلاسة تامة 120 FPS على شاشات الهواتف والشاشات الحديثة --}}
<div class="absolute inset-0 z-0 overflow-hidden pointer-events-none select-none" aria-hidden="true">
    <style>
        @keyframes wsAuroraMesh1 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                opacity: 0.85;
            }
            33% {
                transform: translate3d(40px, -30px, 0) scale(1.12) rotate(8deg);
                opacity: 0.95;
            }
            66% {
                transform: translate3d(-25px, 25px, 0) scale(0.95) rotate(-6deg);
                opacity: 0.80;
            }
        }

        @keyframes wsAuroraMesh2 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
                opacity: 0.80;
            }
            33% {
                transform: translate3d(-40px, 35px, 0) scale(1.15) rotate(-10deg);
                opacity: 0.90;
            }
            66% {
                transform: translate3d(30px, -20px, 0) scale(0.96) rotate(6deg);
                opacity: 0.75;
            }
        }

        @keyframes wsAuroraMesh3 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1) rotate(0deg);
            }
            50% {
                transform: translate3d(35px, 40px, 0) scale(1.15) rotate(12deg);
            }
        }

        @keyframes wsAuroraMesh4 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
            }
            50% {
                transform: translate3d(-30px, -35px, 0) scale(1.10);
            }
        }

        .animate-aurora-mesh-1 {
            animation: wsAuroraMesh1 24s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            will-change: transform, opacity;
            border-radius: 50% 60% 45% 55%;
            transform: translateZ(0);
        }

        .animate-aurora-mesh-2 {
            animation: wsAuroraMesh2 30s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            will-change: transform, opacity;
            border-radius: 55% 45% 60% 40%;
            transform: translateZ(0);
        }

        .animate-aurora-mesh-3 {
            animation: wsAuroraMesh3 28s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            will-change: transform;
            border-radius: 48% 52% 55% 45%;
            transform: translateZ(0);
        }

        .animate-aurora-mesh-4 {
            animation: wsAuroraMesh4 32s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            will-change: transform;
            border-radius: 52% 48% 45% 55%;
            transform: translateZ(0);
        }

        @media (max-width: 768px) {
            .animate-aurora-mesh-1,
            .animate-aurora-mesh-2,
            .animate-aurora-mesh-3,
            .animate-aurora-mesh-4 {
                animation-duration: 40s; /* Slower on mobile to reduce GPU compute */
            }
        }
    </style>

    <div class="relative w-full h-full">
        {{-- ======================================================== --}}
        {{-- SECTION 1 & 2: Hero & Countdown Ambient Waves (أعلى الصفحة) --}}
        {{-- ======================================================== --}}

        {{-- Top Right: Royal Blue Aurora Bloom --}}
        <div class="absolute -top-10 -right-20 w-72 h-72 sm:w-[38rem] sm:h-[38rem] bg-gradient-to-br from-[#0052CC]/20 via-[#0088FF]/12 to-transparent blur-[50px] sm:blur-[120px] animate-aurora-mesh-1"></div>

        {{-- Top Left: Electric Cyan Shimmer --}}
        <div class="absolute top-28 -left-20 w-64 h-64 sm:w-[34rem] sm:h-[34rem] bg-gradient-to-tr from-[#00C4CC]/18 via-[#38BDF8]/12 to-transparent blur-[45px] sm:blur-[110px] animate-aurora-mesh-2"></div>

        {{-- Upper Center Subtle Golden Sunlight Glow (الذهبي العنبري) --}}
        <div class="hidden sm:block absolute top-96 left-1/3 w-[28rem] h-[28rem] bg-gradient-to-br from-[#F59E0B]/10 via-[#FBBF24]/06 to-transparent blur-[100px] animate-aurora-mesh-3 opacity-80"></div>

        {{-- ======================================================== --}}
        {{-- SECTION 3 & 4: Stats & Skills Showcase (وسط الصفحة - Desktop/Tablet) --}}
        {{-- ======================================================== --}}

        {{-- Mid-Right: Golden Amber Warmth behind Skills --}}
        <div class="hidden md:block absolute top-[52rem] -right-24 w-[36rem] h-[36rem] bg-gradient-to-bl from-[#F59E0B]/12 via-[#D97706]/07 to-transparent blur-[120px] animate-aurora-mesh-3 opacity-85"></div>

        {{-- Mid-Left: Royal Blue Competence Waves --}}
        <div class="hidden md:block absolute top-[75rem] -left-24 w-[38rem] h-[38rem] bg-gradient-to-tr from-[#0052CC]/16 via-[#00A3FF]/10 to-transparent blur-[120px] animate-aurora-mesh-1 opacity-90"></div>

        {{-- Center Horizon: Electric Cyan Pulse --}}
        <div class="hidden md:block absolute top-[105rem] right-1/4 w-[32rem] h-[32rem] bg-gradient-to-br from-[#00C4CC]/15 via-[#0284C7]/10 to-transparent blur-[110px] animate-aurora-mesh-2 opacity-85"></div>

        {{-- ======================================================== --}}
        {{-- SECTION 5 & 6: African Forum & Partners (أسفل الصفحة) --}}
        {{-- ======================================================== --}}

        {{-- Deep African Forum Glow --}}
        <div class="hidden md:block absolute top-[140rem] -left-20 w-[36rem] h-[36rem] bg-gradient-to-tr from-[#00C4CC]/16 via-[#0052CC]/12 to-transparent blur-[120px] animate-aurora-mesh-4 opacity-90"></div>

        {{-- Partner Section Warm Accent --}}
        <div class="hidden md:block absolute top-[175rem] -right-20 w-[34rem] h-[34rem] bg-gradient-to-bl from-[#F59E0B]/10 via-[#0088FF]/10 to-transparent blur-[110px] animate-aurora-mesh-3 opacity-80"></div>

        {{-- Footer Horizon Deep Royal Blue Base --}}
        <div class="hidden md:block absolute bottom-10 left-1/3 w-[38rem] h-[30rem] bg-gradient-to-t from-[#0052CC]/15 via-[#00A3FF]/08 to-transparent blur-[120px] animate-aurora-mesh-1 opacity-90"></div>
    </div>
</div>
