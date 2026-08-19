<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-[#020A24]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>WorldSkills Algeria — Live TV Display</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&family=Tajawal:wght@300;400;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: { sans: ['Tajawal', 'Outfit', 'sans-serif'] },
            colors: {
              brand: {
                500: '#0066FF', sky: '#00B8FF',
                dark: '#06205C', bg: '#020A24'
              }
            },
            animation: {
              'ticker': 'ticker 40s linear infinite',
              'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
              ticker: { '0%': { transform: 'translateX(100%)' }, '100%': { transform: 'translateX(-100%)' } }
            }
          }
        }
      }
    </script>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; overflow: hidden; font-family: 'Tajawal', sans-serif; background: #020A24; }
        .live-glow { box-shadow: 0 0 30px rgba(0, 184, 255, 0.25), 0 0 60px rgba(0, 102, 255, 0.1); }
        .medal-gold   { background: linear-gradient(135deg, #F59E0B, #D97706); }
        .medal-silver { background: linear-gradient(135deg, #94A3B8, #64748B); }
        .medal-bronze { background: linear-gradient(135deg, #EA7C1E, #C2600E); }
        @keyframes scanline { 0%, 100% { opacity: 0.03; } 50% { opacity: 0.07; } }
        .scanlines { background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,184,255,0.04) 2px, rgba(0,184,255,0.04) 4px); animation: scanline 4s ease infinite; pointer-events: none; }
    </style>

    @livewireStyles
    <livewire:styles />
    
    <!-- Platform Media & Content Protection System -->
    <x-content-protection />
</head>
<body class="h-screen w-screen overflow-hidden flex flex-col text-white select-none">
    {{ $slot }}
    @livewireScripts
    <livewire:scripts />
</body>
</html>
