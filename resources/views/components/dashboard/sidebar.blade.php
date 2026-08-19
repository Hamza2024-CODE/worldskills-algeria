@props(['categorizedNav' => [], 'items' => []])

@php
$navService     = app(\App\Services\DashboardNavigationService::class);
$user           = auth()->user();
$categorizedNav = !empty($categorizedNav) ? $categorizedNav : ($user ? $navService->getCategorizedNavigation($user) : []);
$locale         = app()->getLocale();

/** Clean SVG icon paths */
$iconPaths = [
    'home'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
    'users'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
    'globe-alt'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zM3.6 9h16.8M3.6 15h16.8M12 3a14.25 14.25 0 000 18 14.25 14.25 0 000-18z"/>',
    'trophy'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728"/>',
    'calendar'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
    'archive-box'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
    'newspaper'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
    'paint-brush'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>',
    'document-text'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
    'shield-check'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
    'chart-bar'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
    'flag'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm0 0h.01"/>',
    'check-circle'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'building-office' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
    'academic-cap'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>',
    'scale'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>',
    'clipboard-list'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
    'user'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
    'photo'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
    'video-camera'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>',
    'sparkles'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
    'bell'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
    'document-check'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'identification'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4m-6 7a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h3"/>',
    'map-pin'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
    'wrench-screwdriver' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
    'truck'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8h4.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2a1 1 0 001-1"/>',
    'cake'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.5a2.5 2.5 0 01-2.5 2.5H5.5A2.5 2.5 0 013 15.5V11a2.5 2.5 0 012.5-2.5h13A2.5 2.5 0 0121 11v4.5z"/>',
    'qr-code'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 0a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2h2zm-6 0H6a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2zm0 10H6a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2zm6 0h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2a2 2 0 012-2z"/>',
    'camera'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>',
    'bolt'            => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
    'clock'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    'book-open'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
];
@endphp

<div
    x-data="{
        collapsed: localStorage.getItem('wsap_sidebar') !== null ? (localStorage.getItem('wsap_sidebar') === 'true') : false,
        search: '',
        toggle() { this.collapsed = !this.collapsed; localStorage.setItem('wsap_sidebar', this.collapsed); }
    }"
    :class="collapsed ? 'w-20' : 'w-72'"
    class="hidden lg:flex bg-white dark:bg-[#0B1120] border-e border-slate-200 dark:border-slate-800/80 flex-col shrink-0 h-[calc(100vh-64px)] sticky top-16 transition-all duration-300 ease-in-out z-30 select-none shadow-sm"
>

    {{-- Collapse/Expand Floating Button --}}
    <button
        @click="toggle()"
        class="absolute top-2.5 -end-3.5 z-50 w-7 h-7 rounded-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 flex items-center justify-center shadow-md hover:scale-110 hover:bg-brand-50 hover:text-brand-600 dark:hover:bg-slate-700 transition-all cursor-pointer"
        title="طي / توسيع القائمة"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
             :class="collapsed ? (document.dir==='rtl' ? 'rotate-180' : '') : (document.dir==='rtl' ? '' : 'rotate-180')"
             class="w-4 h-4 transition-transform duration-300">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="{{ app()->getLocale() === 'ar' ? 'M15.75 19.5L8.25 12l7.5-7.5' : 'M8.25 4.5l7.5 7.5-7.5 7.5' }}"/>
        </svg>
    </button>

    {{-- Quick Search Input Bar --}}
    <div x-show="!collapsed" class="p-3 pt-2.5 pe-5 pb-2 border-b border-slate-100 dark:border-slate-800/80">
        <div class="relative">
            <input type="text"
                   x-model="search"
                   placeholder="{{ $locale === 'fr' ? 'Rechercher...' : ($locale === 'en' ? 'Quick Search...' : 'تصفية وبحث سريع...') }}"
                   class="w-full pl-8 pr-3 py-2 rounded-xl text-xs bg-slate-100/90 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500/40 transition">
            <svg class="w-4 h-4 text-slate-400 absolute {{ $locale === 'ar' ? 'left-2.5' : 'right-2.5' }} top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    {{-- Categorized Navigation Menu --}}
    <nav class="flex-1 overflow-y-auto overflow-x-hidden p-3 space-y-4 scrollbar-none">

        @foreach($categorizedNav as $catIndex => $group)
            @php
                $catName = $group['category'] ?? '';
                $groupItems = $group['items'] ?? [];
            @endphp
            @if(count($groupItems) === 0) @continue @endif

            <div x-data="{ open: true }"
                 x-show="search === '' || {{ json_encode(array_column($groupItems, 'label')) }}.some(l => l.toLowerCase().includes(search.toLowerCase()))"
                 class="space-y-1">

                {{-- Category Section Label --}}
                <div x-show="!collapsed"
                     @click="open = !open"
                     class="flex items-center justify-between px-2.5 py-1.5 rounded-xl cursor-pointer hover:bg-slate-100/80 dark:hover:bg-slate-800/60 transition group/cat">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-500 shrink-0"></span>
                        <span class="text-[11px] font-extrabold uppercase text-slate-500 dark:text-slate-400 tracking-wider">
                            {{ $catName }}
                        </span>
                    </div>
                    <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="open ? '' : '-rotate-90'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>

                {{-- Items Grid --}}
                <div x-show="open || search !== ''" class="space-y-1 pt-0.5">
                    @foreach($groupItems as $item)
                        @php
                            try {
                                $isActive = request()->routeIs($item['route'] ?? '');
                                $href = route($item['route'] ?? 'admin.dashboard');
                            } catch (\Exception $e) {
                                $isActive = false;
                                $href = '#';
                            }
                            $iconName = $item['icon'] ?? 'home';
                            $svgPath  = $iconPaths[$iconName] ?? $iconPaths['home'];
                        @endphp

                        <a href="{{ $href }}"
                           x-show="search === '' || '{{ strtolower($item['label']) }}'.includes(search.toLowerCase())"
                           :class="collapsed ? 'justify-center px-0' : 'px-3'"
                           class="relative flex items-center gap-3 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 group/item {{ $isActive ? 'bg-[#0066FF] text-white font-black shadow-md shadow-blue-500/20' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white' }}"
                        >
                            {{-- Icon Wrapper with Strict Size --}}
                            <div class="w-5 h-5 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover/item:scale-110 {{ $isActive ? 'text-white' : 'text-slate-500 dark:text-slate-400 group-hover/item:text-brand-500' }}" aria-hidden="true">
                                    {!! $svgPath !!}
                                </svg>
                            </div>

                            {{-- Label Text --}}
                            <span x-show="!collapsed" class="truncate leading-relaxed font-bold">
                                {{ $item['label'] }}
                            </span>

                            {{-- Active Dot in Collapsed View --}}
                            @if($isActive)
                                <span class="absolute end-1.5 top-1/2 -translate-y-1/2 w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                            @endif

                            {{-- Floating Tooltip when Collapsed --}}
                            <div x-show="collapsed"
                                 x-cloak
                                 class="absolute {{ app()->getLocale() === 'ar' ? 'right-full mr-2' : 'left-full ml-2' }} px-3 py-2 rounded-xl text-[11px] font-bold text-white bg-slate-900 dark:bg-slate-800 border border-slate-700 shadow-xl pointer-events-none opacity-0 group-hover/item:opacity-100 transition-opacity duration-150 whitespace-nowrap z-50">
                                {{ $item['label'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div x-show="!collapsed" class="border-t border-slate-100 dark:border-slate-800/80 my-1"></div>
        @endforeach

    </nav>

    {{-- Bottom Profile User Summary --}}
    <div class="p-3 border-t border-slate-200 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/50">
        <a href="{{ route('profile') }}"
           :class="collapsed ? 'justify-center px-0' : 'px-2 py-1.5'"
           class="w-full flex items-center gap-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition-all shadow-xs group"
        >
            <div class="w-8 h-8 rounded-xl bg-[#06205C] overflow-hidden shrink-0 border border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-center text-white font-black text-xs">
                <img src="{{ $user?->avatar_url }}" alt="{{ $user?->name }}" class="w-full h-full object-cover">
            </div>
            <div x-show="!collapsed" class="flex flex-col truncate">
                <span class="truncate font-extrabold text-slate-900 dark:text-white leading-tight text-xs">{{ $user?->name ?? '' }}</span>
                <span class="text-[10px] text-slate-400 font-bold leading-tight mt-0.5 truncate">{{ $user?->email ?? '' }}</span>
            </div>
        </a>
    </div>

</div>
