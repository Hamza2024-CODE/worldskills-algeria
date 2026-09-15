<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-[#F8FAFC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'WorldSkills Algeria') }} — {{ $title ?? __('messages.hero_subtitle') }}</title>

    {!! app(\App\Services\SettingsEngine::class)->getDesignTokensCss() !!}

    <!-- PWA Manifest & Mobile Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#041235">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="WorldSkills DZ">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" type="image/svg+xml" href="/logo.svg">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon.png">

    <!-- Preconnect & Typography: Cairo, Readex Pro, Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Outfit:wght@400;500;600;700;800;900&family=Readex+Pro:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Compiled Production Vite Engine (Zero CDN Dependency) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Content & Media Protection -->
    <x-content-protection />
</head>
<body class="font-sans antialiased min-h-full flex flex-col text-ws-slate bg-ws-bg text-start selection:bg-ws-primary selection:text-white relative">

    @unless(request()->routeIs('coming-soon') || request()->is('coming-soon'))
        <!-- Floating Glassmorphic Official Navbar -->
        <x-navbar />
    @endunless

    <!-- Main Content Area -->
    <main class="flex-grow min-h-[calc(100vh-320px)] {{ request()->routeIs('home') ? '' : 'pt-2 sm:pt-4' }} pb-20 sm:pb-28">
        {{ $slot }}
    </main>

    @unless(request()->routeIs('coming-soon') || request()->is('coming-soon'))
        <!-- Official High-Contrast Footer -->
        <x-footer />

        <!-- Mobile App Bottom Navigation -->
        <x-mobile-bottom-nav />
    @endunless

    <!-- Cookie Banner & PWA Engine -->
    <x-cookie-banner />
    <x-pwa-installer />

    @livewireScripts
</body>
</html>
