@props(['title' => 'WSAP Workspace'])

@php
    $navService      = app(\App\Services\DashboardNavigationService::class);
    $user            = auth()->user();
    $categorizedNav  = $user ? $navService->getCategorizedNavigation($user) : [];
    $items           = $user ? $navService->getNavigation($user) : [];
    $activeEvent     = app(\App\Services\ActiveEventService::class)->getActiveEvent();
    $locale          = app()->getLocale();
    $dir             = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}" class="h-full" x-data="{ dark: localStorage.getItem('wsap_dark_mode') === 'true' }" x-init="document.documentElement.classList.toggle('dark', dark)" :class="dark ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — WorldSkills Algeria</title>
    <meta name="description" content="WSAP — المنصة الوطنية الرسمية لأولمبياد المهن الجزائرية">
    <meta name="theme-color" content="#020A24">

    {{-- PWA Manifest & Mobile Meta Tags --}}
    <link rel="manifest" href="/manifest.json">
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="WorldSkills DZ">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/icon-192.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/icon-512.png">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">
    <link rel="icon" type="image/svg+xml" href="/logo.svg">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Dynamic Design Tokens from SettingsEngine --}}
    {!! app(\App\Services\SettingsEngine::class)->getDesignTokensCss() !!}

    {{-- Tailwind CSS CDN --}}
    <script>
        (function(){const w=console.warn;console.warn=function(...a){if(a[0]&&typeof a[0]==='string'&&a[0].includes('cdn.tailwindcss.com'))return;w.apply(console,a);};})();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#EEF6FF', 100:'#E0F0FF', 500:'#0066FF', 600:'#0052CC', 700:'#063B8F', sky:'#00B8FF', dark:'#020A24' }
                    },
                    fontFamily: { sans: ['Cairo', 'Outfit', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        /* ── Base ── */
        *, ::before, ::after { box-sizing: border-box; }
        body { font-family: 'Cairo', 'Outfit', sans-serif; }
        .scrollbar-none::-webkit-scrollbar { display: none; }
        .scrollbar-none { -ms-overflow-style: none; scrollbar-width: none; }

        /* ── Light Mode Design Tokens ── */
        :root {
            --ws-bg:         #F4F7FC;
            --ws-surface:    rgba(255,255,255,0.96);
            --ws-border:     rgba(226,232,240,0.8);
            --ws-text:       #020A24;
            --ws-muted:      #64748B;
            --ws-sidebar:    #FFFFFF;
            --ws-sidebar-border: rgba(226,232,240,0.8);
        }

        /* ── Dark Mode Design Tokens ── */
        .dark {
            --ws-bg:         #0B1120;
            --ws-surface:    rgba(15,23,42,0.95);
            --ws-border:     rgba(30,41,59,0.8);
            --ws-text:       #E2E8F0;
            --ws-muted:      #64748B;
            --ws-sidebar:    #0F172A;
            --ws-sidebar-border: rgba(30,41,59,0.8);
        }

        body {
            background: var(--ws-bg);
            color: var(--ws-text);
            transition: background 0.3s, color 0.3s;
        }

        /* ── Glass Cards ── */
        .glass-card {
            background: var(--ws-surface);
            backdrop-filter: blur(12px);
            border-color: var(--ws-border);
        }
        .dark .glass-card {
            border-color: rgba(30,41,59,0.6);
        }

        /* ── Micro-animations ── */
        @keyframes fadeSlideIn {
            from { opacity:0; transform:translateY(6px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .animate-fade-slide-in { animation: fadeSlideIn 0.3s ease both; }

        /* ── Global Mobile Responsiveness Engine ── */
        html, body {
            max-width: 100vw;
            overflow-x: hidden !important;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        img, svg, video, iframe {
            max-width: 100%;
            height: auto;
        }

        /* Responsive Table Containers */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Touch Targets */
        .touch-target { min-width: 44px; min-height: 44px; }

        @media (max-width: 640px) {
            main {
                padding-left: 0.75rem !important;
                padding-right: 0.75rem !important;
                padding-top: 1rem !important;
                padding-bottom: 1.5rem !important;
            }
            h1 { font-size: 1.5rem !important; line-height: 1.25 !important; }
            h2 { font-size: 1.25rem !important; line-height: 1.3 !important; }
        }
    </style>

    @livewireStyles
</head>

<body class="h-full antialiased font-sans flex flex-col min-h-screen"
      x-data="{ mobileNavOpen: false, dark: localStorage.getItem('wsap_dark_mode') === 'true' }">

    {{-- Top Navigation Bar --}}
    <x-dashboard.topbar :user="$user" :activeEvent="$activeEvent" />

    {{-- Main Layout: Sidebar + Content --}}
    <div class="flex-1 flex w-full">

        {{-- Desktop Collapsible Sidebar --}}
        <x-dashboard.sidebar :categorizedNav="$categorizedNav" :items="$items" />

        {{-- Mobile Drawer Navigation --}}
        <x-dashboard.mobile-nav :categorizedNav="$categorizedNav" :items="$items" />

        {{-- Main Content --}}
        <main class="flex-1 min-w-0 p-4 sm:p-6 lg:p-8 pb-20 md:pb-8 space-y-6 animate-fade-slide-in overflow-x-hidden">
            {{ $slot }}
        </main>
    </div>

    {{-- Native Smartphone Mobile App Bottom Tab Bar Navigation --}}
    <x-mobile-bottom-nav />

    @livewireScripts

    {{-- Global Real-time Toast Notifications System --}}
    <div x-data="{
            toasts: [],
            add(e) {
                const detail = Array.isArray(e.detail) ? e.detail[0] : e.detail;
                const toast = {
                    id: Date.now(),
                    type: detail?.type || 'success',
                    msg: detail?.msg || 'تمت العملية بنجاح'
                };
                this.toasts.push(toast);
                setTimeout(() => { this.remove(toast.id); }, 4000);
            },
            remove(id) {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }
        }"
        @notify.window="add($event)"
        class="fixed bottom-6 left-6 z-50 flex flex-col gap-2.5 max-w-sm pointer-events-none">
        <template x-for="t in toasts" :key="t.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                 :class="{
                    'bg-emerald-600 border-emerald-500 text-white': t.type === 'success',
                    'bg-rose-600 border-rose-500 text-white': t.type === 'danger' || t.type === 'error',
                    'bg-amber-500 border-amber-400 text-white': t.type === 'warning',
                    'bg-blue-600 border-blue-500 text-white': t.type === 'info'
                 }"
                 class="pointer-events-auto p-4 rounded-2xl shadow-2xl border flex items-center justify-between gap-3 text-xs font-bold font-sans">
                <div class="flex items-center gap-2.5">
                    <template x-if="t.type === 'success'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </template>
                    <template x-if="t.type === 'warning'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </template>
                    <template x-if="t.type !== 'success' && t.type !== 'warning'">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </template>
                    <span x-text="t.msg" class="leading-relaxed"></span>
                </div>
                <button @click="remove(t.id)" class="text-white/80 hover:text-white font-bold p-1 rounded-lg hover:bg-white/20 transition">✕</button>
            </div>
        </template>
    </div>

    {{-- Dark mode sync on page load --}}
    <script>
        (function() {
            const dark = localStorage.getItem('wsap_dark_mode') === 'true';
            document.documentElement.classList.toggle('dark', dark);
        })();
    </script>
    <x-pwa-installer />
</body>
</html>
