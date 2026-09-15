{{-- WorldSkills Algeria 2026 — The Hybrid Dynamic Background Experience --}}
{{-- دمج الشبكة الهندسية الدقيقة مع الهالات الضبابية المتنفسة وتوهج الفأرة التفاعلي --}}
<div 
    x-data="{
        mouseX: '50%',
        mouseY: '30%',
        isHovering: false,
        onMouseMove(e) {
            this.mouseX = e.clientX + 'px';
            this.mouseY = e.clientY + 'px';
            this.isHovering = true;
        }
    }"
    @mousemove.window.passive="onMouseMove($event)"
    class="pointer-events-none select-none"
    aria-hidden="true"
>
    <style>
        @keyframes wsBreathOrb1 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 0.8;
            }
            50% {
                transform: translate3d(40px, -35px, 0) scale(1.22);
                opacity: 1;
            }
        }
        @keyframes wsBreathOrb2 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 0.75;
            }
            50% {
                transform: translate3d(-45px, 40px, 0) scale(1.18);
                opacity: 0.95;
            }
        }
        @keyframes wsBreathOrb3 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 0.7;
            }
            50% {
                transform: translate3d(35px, 30px, 0) scale(1.25);
                opacity: 0.95;
            }
        }
        @keyframes wsBreathOrb4 {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 0.65;
            }
            50% {
                transform: translate3d(-30px, -30px, 0) scale(1.15);
                opacity: 0.9;
            }
        }
        .animate-breath-1 {
            animation: wsBreathOrb1 14s ease-in-out infinite;
        }
        .animate-breath-2 {
            animation: wsBreathOrb2 18s ease-in-out infinite;
        }
        .animate-breath-3 {
            animation: wsBreathOrb3 16s ease-in-out infinite;
        }
        .animate-breath-4 {
            animation: wsBreathOrb4 20s ease-in-out infinite;
        }
    </style>

    {{-- 1. Interactive Cursor Spotlight Glow (توهج الفأرة الحي الذي يتبع المؤشر) --}}
    <div 
        class="fixed inset-0 z-0 transition-opacity duration-700 pointer-events-none"
        :style="`background: radial-gradient(700px circle at ${mouseX} ${mouseY}, rgba(0, 196, 204, 0.08), rgba(0, 82, 204, 0.04), transparent 75%)`"
        :class="isHovering ? 'opacity-100' : 'opacity-0'"
    ></div>

    {{-- 2. Technical Vocational Blueprint Grid (الشبكة الهندسية الدقيقة مع علامات التوجيه) --}}
    <div class="fixed inset-0 z-0 opacity-40 mix-blend-multiply pointer-events-none overflow-hidden [mask-image:radial-gradient(ellipse_at_center,white_40%,transparent_90%)]">
        <svg class="w-full h-full stroke-slate-300/40" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                {{-- Blueprint Minor Grid --}}
                <pattern id="ws-blueprint-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.75" />
                    {{-- Engineering crosshairs at intersection --}}
                    <path d="M 0 5 L 0 -5 M -5 0 L 5 0" stroke="rgba(2, 132, 199, 0.35)" stroke-width="0.75" />
                </pattern>
                {{-- Blueprint Major Technical Squares --}}
                <pattern id="ws-blueprint-major" width="200" height="200" patternUnits="userSpaceOnUse">
                    <rect width="200" height="200" fill="url(#ws-blueprint-grid)" />
                    <path d="M 200 0 L 0 0 0 200" fill="none" stroke="rgba(0, 82, 204, 0.15)" stroke-width="1.25" />
                    <circle cx="0" cy="0" r="1.5" fill="rgba(0, 196, 204, 0.5)" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#ws-blueprint-major)" />
        </svg>
    </div>

    {{-- 3. Breathing Ambient Aurora Glowing Orbs (الهالات الضبابية المتنفسة) --}}
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        {{-- Orb 1: Royal Blue Energy at Top-Right --}}
        <div class="absolute -top-10 right-1/4 w-[36rem] h-[36rem] rounded-full bg-gradient-to-br from-[#0052CC]/15 via-[#0088FF]/10 to-transparent blur-[110px] sm:blur-[140px] animate-breath-1"></div>

        {{-- Orb 2: Electric Cyan Vitality at Middle-Left --}}
        <div class="absolute top-[35rem] -left-20 w-[42rem] h-[42rem] rounded-full bg-gradient-to-tr from-[#00C4CC]/14 via-[#38BDF8]/10 to-transparent blur-[120px] sm:blur-[150px] animate-breath-2"></div>

        {{-- Orb 3: Warm Golden Flame / Algerian Sun at Mid-Right --}}
        <div class="absolute top-[80rem] -right-20 w-[38rem] h-[38rem] rounded-full bg-gradient-to-bl from-[#F59E0B]/10 via-[#FBBF24]/08 to-transparent blur-[110px] sm:blur-[140px] animate-breath-3"></div>

        {{-- Orb 4: Algerian Emerald & Sky Harmony at Forum Section --}}
        <div class="absolute top-[130rem] left-1/4 w-[40rem] h-[40rem] rounded-full bg-gradient-to-tr from-[#008744]/08 via-[#00C4CC]/10 to-transparent blur-[120px] sm:blur-[160px] animate-breath-4"></div>

        {{-- Orb 5: Deep Horizon Anchor near Footer --}}
        <div class="absolute bottom-20 right-10 w-[34rem] h-[34rem] rounded-full bg-gradient-to-tl from-[#0052CC]/12 via-[#00A3FF]/08 to-transparent blur-[110px] sm:blur-[140px] animate-breath-1"></div>
    </div>
</div>
