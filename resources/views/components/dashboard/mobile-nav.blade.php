@props([
    'categorizedNav' => [],
    'items'          => [],
    'user'           => auth()->user()
])

@php
    $locale = app()->getLocale();
    $iconPaths = [
        'home'               => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        'users'              => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'user'               => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        'clipboard-list'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
        'flag'               => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>',
        'trophy'             => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.428a2 2 0 00-1.022.547l-1.42 1.42a2 2 0 00-.547 1.022l-.477 2.387a2 2 0 002.409 2.409l2.387-.477a2 2 0 001.022-.547l1.42-1.42a2 2 0 00.547-1.022l.477-2.387a6 6 0 00-.517-3.86l-.158-.318a6 6 0 01-.517-3.86l.477-2.387a2 2 0 00-.547-1.022l-1.42-1.42a2 2 0 00-1.022-.547l-2.387.477a2 2 0 00-2.409 2.409l.477 2.387a2 2 0 00.547 1.022l1.42 1.42z"/>',
        'scale'              => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l9-4 9 4M3 6v14a2 2 0 002 2h14a2 2 0 002-2V6M3 6l9 4 9-4M12 10v12"/>',
        'chart-bar'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
        'newspaper'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
        'shield-check'       => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'building-office'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0V11m0 0h4m-4 0H9m4 0V7m0 0h4m-4 0H9"/>',
        'sparkles'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
        'bell'               => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
        'document-check'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'identification'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4m-6 7a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h3"/>',
        'wrench-screwdriver' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'truck'              => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8h4.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h2a1 1 0 001-1"/>',
        'camera'             => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'calendar'           => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'paint-brush'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4c0-1.423.806-2.585 2-3.13V5a2 2 0 012-2h4a2 2 0 012 2v8.87c1.194.545 2 1.707 2 3.13a4 4 0 01-4 4H7z"/>',
        'document-text'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
    ];
@endphp

<div x-show="mobileNavOpen"
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 lg:hidden flex"
     role="dialog"
     aria-modal="true"
     x-data="{ mobileSearch: '' }">

    {{-- BACKDROP --}}
    <div @click="mobileNavOpen = false" class="fixed inset-0 bg-slate-950/80 backdrop-blur-md"></div>

    {{-- DRAWER CONTAINER --}}
    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white dark:bg-[#070D1E] text-slate-900 dark:text-white border-e border-slate-200 dark:border-slate-800 shadow-2xl overflow-y-auto">
        
        <div class="p-4 space-y-4">
            
            {{-- DRAWER HEADER --}}
            <div class="flex items-center justify-between pb-3 border-b border-slate-200/80 dark:border-slate-800">
                <div class="bg-slate-100 dark:bg-slate-800/80 px-3 py-1.5 rounded-2xl flex items-center gap-2 border border-slate-200 dark:border-slate-700 shadow-inner">
                    <img src="/ministry-logo-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-6 w-auto object-contain">
                    <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 shrink-0"></div>
                    <img src="/logo.svg" alt="WorldSkills Algeria" class="h-6 w-auto object-contain">
                </div>

                <button @click="mobileNavOpen = false" type="button" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 hover:text-slate-900 dark:hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- SEARCH --}}
            <div class="relative">
                <input 
                    type="text"
                    x-model="mobileSearch"
                    placeholder="{{ $locale === 'fr' ? 'Recherche rapide...' : ($locale === 'en' ? 'Quick search...' : 'بحث سريع في القائمة...') }}"
                    class="w-full pl-8 pr-3 py-2 rounded-xl text-xs bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 dark:focus:ring-amber-500/50 transition"
                >
                <svg class="w-4 h-4 text-slate-400 absolute {{ $locale === 'ar' ? 'left-3' : 'right-3' }} top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            {{-- CATEGORIZED SECTIONS --}}
            <div class="space-y-4 pt-1">
                @foreach($categorizedNav as $group)
                    @php
                        $catName = $group['category'] ?? '';
                        $groupItems = $group['items'] ?? [];
                    @endphp
                    @if(count($groupItems) === 0) @continue @endif

                    <div x-data="{ open: true }"
                         x-show="mobileSearch === '' || {{ json_encode(array_column($groupItems, 'label')) }}.some(l => l.toLowerCase().includes(mobileSearch.toLowerCase()))"
                         class="space-y-1.5">

                        <div class="flex items-center gap-2 px-2 py-1">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#0052CC] dark:bg-amber-500"></span>
                            <span class="text-[11px] font-black text-slate-500 dark:text-amber-400 uppercase tracking-wider font-mono">
                                {{ $catName }}
                            </span>
                        </div>

                        <div class="space-y-1">
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
                                   @click="mobileNavOpen = false"
                                   x-show="mobileSearch === '' || '{{ strtolower($item['label']) }}'.includes(mobileSearch.toLowerCase())"
                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 {{ $isActive ? 'bg-[#0052CC] text-white font-black shadow-lg shadow-blue-500/25 dark:bg-gradient-to-r dark:from-[#06205C] dark:via-[#0A2E80] dark:to-[#06205C] dark:text-white dark:border dark:border-amber-500/40' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}"
                                >
                                    <div class="w-6 h-6 rounded-lg flex items-center justify-center shrink-0 {{ $isActive ? 'bg-white/20 text-white dark:bg-amber-500/20 dark:text-amber-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4" aria-hidden="true">
                                            {!! $svgPath !!}
                                        </svg>
                                    </div>

                                    <span class="truncate leading-snug">{{ $item['label'] }}</span>

                                    @if($isActive)
                                        <span class="w-2 h-2 rounded-full bg-white dark:bg-amber-400 animate-pulse ml-auto"></span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- USER FOOTER & LOGOUT --}}
        <div class="p-4 border-t border-slate-200/80 dark:border-slate-800 mt-auto space-y-3 pb-8">
            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-2.5 overflow-hidden ps-1">
                    <div class="w-8 h-8 rounded-lg bg-[#06205C] overflow-hidden shrink-0 border border-slate-200 dark:border-amber-500/30">
                        <img src="{{ $user?->avatar_url }}" alt="{{ $user?->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex flex-col truncate">
                        <span class="text-xs font-black text-slate-900 dark:text-white truncate">{{ $user?->name ?? '' }}</span>
                        <span class="text-[10px] text-blue-600 dark:text-amber-400 font-bold truncate">{{ $user?->email ?? '' }}</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-black text-rose-600 dark:text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
                    </svg>
                    <span>{{ $locale === 'fr' ? 'Déconnexion' : ($locale === 'en' ? 'Sign Out' : 'تسجيل الخروج') }}</span>
                </button>
            </form>
        </div>

    </div>

</div>
