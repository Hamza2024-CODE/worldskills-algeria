<div class="py-12 bg-[#F4F7FC] min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Title Banner -->
        <div class="text-center space-y-3 relative group">
            
            <h1 class="text-3xl sm:text-5xl font-black text-[#06205C] tracking-tight">
                {{ app()->getLocale() === 'fr' ? 'Rechercher dans la Plateforme' : (app()->getLocale() === 'en' ? 'Search Platform Content & Archive' : 'البحث المباشر في قاعدة بيانات المنصة') }}
            </h1>
            
            <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl mx-auto">
                {{ app()->getLocale() === 'fr' ? 'Recherche en temps réel dans les compétences, actualités, événements, établissements et partenaires.' : (app()->getLocale() === 'en' ? 'Live real-time search across skills, news, events, institutes and partners.' : 'ابحث فورياً عن أي تخصص مهاراتي، خبر إعلامي، حفل أو حدث، مركز تكوين، أو جهة راعية.') }}
            </p>
        </div>

        <!-- Search Input Bar & Category Filters -->
        <div class="space-y-4">
            <div class="relative max-w-3xl mx-auto">
                <div class="absolute inset-y-0 start-0 ps-5 flex items-center pointer-events-none text-[#0066FF]">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                
                <input type="text" 
                       wire:model.live.debounce.250ms="query" 
                       placeholder="{{ app()->getLocale() === 'fr' ? 'Tapez votre recherche (Métier, Actualité, Événement)...' : (app()->getLocale() === 'en' ? 'Type search query (Skill code, Event, News)...' : 'اكتب كلمة البحث (اسم التخصص، كود المهنة SKILL-16، الخبر، المؤسسة)...') }}" 
                       class="w-full ps-14 pe-14 py-4 sm:py-5 rounded-3xl bg-white border-2 border-slate-200/90 text-sm sm:text-base font-bold shadow-2xl focus:outline-none focus:border-[#0066FF] transition-all text-[#06205C] placeholder:text-slate-400">

                @if(strlen($query) > 0)
                    <button wire:click="$set('query', '')" class="absolute inset-y-0 end-0 pe-5 flex items-center text-slate-400 hover:text-red-500 font-bold transition"><x-ws.icon name="x-mark" class="w-5 h-5" /></button>
                @endif
            </div>

            <!-- Category Quick Filter Pills -->
            <div class="flex items-center justify-center flex-wrap gap-2 pt-2">
                <button type="button" wire:click="setCategory('all')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'all' ? 'bg-[#06205C] text-white border-[#06205C] shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Tous' : (app()->getLocale() === 'en' ? 'All' : 'الكل') }}
                </button>
                <button type="button" wire:click="setCategory('skills')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'skills' ? 'bg-[#0066FF] text-white border-[#0066FF] shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Métiers & Skills' : (app()->getLocale() === 'en' ? 'Skills' : 'التخصصات والمهن') }}
                </button>
                <button type="button" wire:click="setCategory('news')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'news' ? 'bg-amber-600 text-white border-amber-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Actualités' : (app()->getLocale() === 'en' ? 'News' : 'الأخبار والمقالات') }}
                </button>
                <button type="button" wire:click="setCategory('events')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'events' ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Événements' : (app()->getLocale() === 'en' ? 'Events' : 'الأجندة والفعاليات') }}
                </button>
                <button type="button" wire:click="setCategory('establishments')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'establishments' ? 'bg-purple-600 text-white border-purple-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Établissements' : (app()->getLocale() === 'en' ? 'Institutes' : 'المؤسسات التدريبية') }}
                </button>
                <button type="button" wire:click="setCategory('partners')" class="px-4 py-1.5 rounded-full text-xs font-black transition-all border {{ $selectedCategory === 'partners' ? 'bg-rose-600 text-white border-rose-600 shadow-md' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50' }}">
                    {{ app()->getLocale() === 'fr' ? 'Partenaires' : (app()->getLocale() === 'en' ? 'Partners' : 'الشركاء والرعاة') }}
                </button>
            </div>
        </div>

        <!-- Search Results Section -->
        @php
            $hasActiveSearch = mb_strlen($query) >= 1 || $selectedCategory !== 'all';
        @endphp
        @if($hasActiveSearch)
            
            <div class="space-y-10 pt-4">
                
                <!-- Search Summary Bar -->
                <div class="flex items-center justify-between bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
                    <span class="text-xs font-bold text-slate-600">
                        @if(mb_strlen($query) >= 1)
                            {{ app()->getLocale() === 'fr' ? 'Résultats pour :' : (app()->getLocale() === 'en' ? 'Search results for:' : 'نتائج البحث عن:') }}
                            <strong class="text-[#0066FF]">"{{ $query }}"</strong>
                        @else
                            {{ app()->getLocale() === 'fr' ? 'Affichage de la catégorie :' : (app()->getLocale() === 'en' ? 'Browsing category:' : 'استعراض الفئة:') }}
                            <strong class="text-[#0066FF]">{{ $selectedCategory }}</strong>
                        @endif
                    </span>
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-[#0066FF] font-mono font-black text-xs">
                        {{ $totalResults }} {{ app()->getLocale() === 'fr' ? 'résultats trouvés' : (app()->getLocale() === 'en' ? 'results found' : 'نتيجة مطابقة') }}
                    </span>
                </div>

                @if($totalResults === 0)
                    <div class="bg-white rounded-3xl p-12 text-center shadow-lg border border-slate-200 space-y-3">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#06205C]">
                            {{ app()->getLocale() === 'fr' ? 'Aucun résultat trouvé' : (app()->getLocale() === 'en' ? 'No matching results' : 'لم يتم العثور على نتائج مطابقة') }}
                        </h3>
                        <p class="text-xs text-slate-400 font-medium max-w-md mx-auto">
                            {{ app()->getLocale() === 'fr' ? 'Essayez de chercher par mots clés comme "Mécanique", "Web", "Énergie", ou le code du métier "SKILL-16".' : (app()->getLocale() === 'en' ? 'Try searching using keywords like "Mechanics", "Web", "Energy", or skill code "SKILL-16".' : 'جرب البحث باستخدام كلمات رئيسية أخرى مثل "ميكانيكا"، "ويب"، "طاقة"، "افتتاح"، أو كود التخصص مثل "SKILL-16".') }}
                        </p>
                    </div>
                @endif

                <!-- 1. Skills Results -->
                @if($skills->count() > 0)
                    <div class="space-y-4">
                        <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b-2 border-slate-200 pb-2">
                            <span class="w-3 h-3 rounded-full bg-[#0066FF]"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Métiers & Disciplines' : (app()->getLocale() === 'en' ? 'Skills & Occupations' : 'التخصصات والمهن الأولمبية') }}</span>
                            <span class="text-xs font-mono text-slate-400 font-bold">({{ $skills->count() }})</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($skills as $sk)
                                @php $skImg = $sk->getImageUrl(); @endphp
                                <a href="{{ route('skills') }}" class="bg-white rounded-3xl overflow-hidden shadow-lg border border-slate-200 hover:shadow-2xl hover:border-[#0066FF] transition-all group flex flex-col justify-between">
                                    <div class="h-36 bg-slate-900 relative overflow-hidden">
                                        <img src="{{ $skImg }}" alt="{{ $sk->getLocalized('name') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-transparent"></div>
                                        <span class="absolute top-3 start-3 px-3 py-1 rounded-full bg-[#0066FF] text-white font-mono font-black text-xs shadow-md">
                                            {{ $sk->code }}
                                        </span>
                                    </div>
                                    <div class="p-5 space-y-2">
                                        <h4 class="text-base font-black text-[#06205C] group-hover:text-[#0066FF] transition leading-snug">
                                            {{ $sk->getLocalized('name') }}
                                        </h4>
                                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                            {{ $sk->getLocalized('description') }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 2. News Articles Results -->
                @if($news->count() > 0)
                    <div class="space-y-4">
                        <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b-2 border-slate-200 pb-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Actualités & Presse' : (app()->getLocale() === 'en' ? 'News & Articles' : 'الأخبار والتغطيات الإعلامية') }}</span>
                            <span class="text-xs font-mono text-slate-400 font-bold">({{ $news->count() }})</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($news as $article)
                                <a href="{{ route('news') }}" class="bg-white rounded-2xl p-4 shadow-md border border-slate-200 hover:border-amber-500 transition flex items-center gap-4 group">
                                    <div class="w-16 h-16 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 font-bold border border-amber-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                    <div class="space-y-1 min-w-0">
                                        <h4 class="text-sm font-bold text-[#06205C] group-hover:text-amber-600 transition leading-snug line-clamp-1">
                                            {{ $article->getLocalized('title') }}
                                        </h4>
                                        <span class="text-[11px] text-slate-400 block">
                                            {{ optional($article->published_at)->format('Y-m-d') ?? now()->format('Y-m-d') }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 3. Events Results -->
                @if($events->count() > 0)
                    <div class="space-y-4">
                        <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b-2 border-slate-200 pb-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Agenda & Événements' : (app()->getLocale() === 'en' ? 'Events & Calendar' : 'الأجندة والفعاليات الرسمية') }}</span>
                            <span class="text-xs font-mono text-slate-400 font-bold">({{ $events->count() }})</span>
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($events as $ev)
                                <a href="{{ route('events') }}" class="bg-white rounded-2xl p-4 shadow-md border border-slate-200 hover:border-emerald-500 transition flex items-center gap-4 group">
                                    <div class="w-14 h-14 rounded-xl bg-emerald-50 text-emerald-600 flex flex-col items-center justify-center flex-shrink-0 font-black border border-emerald-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="space-y-1 min-w-0">
                                        <h4 class="text-sm font-bold text-[#06205C] group-hover:text-emerald-600 transition leading-snug line-clamp-1">
                                            {{ $ev->getLocalized('title') }}
                                        </h4>
                                        <span class="text-[11px] text-slate-400 block">
                                            <x-ws.icon name="map-pin" class="w-3.5 h-3.5 inline-block me-1 text-slate-400" /> {{ $ev->venue ?: 'الجزائر العاصمة' }}
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- 4. Partners & Sponsors Results -->
                @if($partners->count() > 0)
                    <div class="space-y-4">
                        <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2 border-b-2 border-slate-200 pb-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors' : (app()->getLocale() === 'en' ? 'Partners & Sponsors' : 'الشركاء والجهات الراعية') }}</span>
                            <span class="text-xs font-mono text-slate-400 font-bold">({{ $partners->count() }})</span>
                        </h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($partners as $pt)
                                <a href="{{ route('partners') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 hover:border-rose-500 transition text-center flex flex-col items-center justify-center gap-2 group">
                                    @if($pt->logo_path)
                                        <img src="{{ asset($pt->logo_path) }}" alt="{{ $pt->getLocalized('name') }}" class="h-10 w-auto object-contain">
                                    @else
                                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 font-black text-sm flex items-center justify-center">
                                            {{ mb_substr($pt->getLocalized('name'), 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="text-xs font-bold text-[#06205C] group-hover:text-rose-600 transition">
                                        {{ $pt->getLocalized('name') }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        @else
            <!-- Default Prompt when no query typed yet and no category selected -->
            <div class="bg-white rounded-3xl p-12 text-center shadow-lg border border-slate-200 space-y-4 max-w-3xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-blue-50 text-[#0066FF] mx-auto flex items-center justify-center border border-blue-100 shadow-inner">
                    <svg class="w-8 h-8 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h3 class="text-xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Commencez votre recherche' : (app()->getLocale() === 'en' ? 'Start Searching' : 'ابدأ كتابة كلمة البحث أو اختر فئة أعلاه') }}
                </h3>
                <p class="text-xs text-slate-500 font-bold max-w-md mx-auto leading-relaxed">
                    {{ app()->getLocale() === 'fr' ? 'Le moteur de recherche global est connecté à 100% à la base de données officielle pour vous donner un accès immédiat aux 64 métiers, actualités et événements.' : (app()->getLocale() === 'en' ? 'The global search engine is 100% connected to the official database giving you instant access to all 64 skills, news and events.' : 'محرك البحث الشامل مرتبط 100% بقاعدة بيانات المنصة الرسمية. اختر فئة أو اكتب كلمة بحث للوصول الفوري إلى أحدث المهن والتخصصات الـ 64، الأخبار، الأحداث، والمؤسسات.') }}
                </p>
                <!-- Quick Category Browse Shortcuts -->
                <div class="flex flex-wrap justify-center gap-2 pt-2">
                    <button type="button" wire:click="setCategory('skills')" class="px-4 py-2 rounded-xl text-xs font-black bg-[#0066FF] text-white hover:bg-[#0050CC] transition shadow-sm">
                        {{ app()->getLocale() === 'fr' ? 'Voir tous les Métiers' : (app()->getLocale() === 'en' ? 'Browse All Skills' : 'استعراض جميع المهن الـ 64') }}
                    </button>
                    <button type="button" wire:click="setCategory('news')" class="px-4 py-2 rounded-xl text-xs font-black bg-amber-500 text-white hover:bg-amber-600 transition shadow-sm">
                        {{ app()->getLocale() === 'fr' ? 'Voir les Actualités' : (app()->getLocale() === 'en' ? 'Browse News' : 'الأخبار والمستجدات') }}
                    </button>
                    <button type="button" wire:click="setCategory('events')" class="px-4 py-2 rounded-xl text-xs font-black bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                        {{ app()->getLocale() === 'fr' ? 'Voir les Événements' : (app()->getLocale() === 'en' ? 'Browse Events' : 'الفعاليات والأجندة') }}
                    </button>
                    <button type="button" wire:click="setCategory('partners')" class="px-4 py-2 rounded-xl text-xs font-black bg-rose-600 text-white hover:bg-rose-700 transition shadow-sm">
                        {{ app()->getLocale() === 'fr' ? 'Voir les Partenaires' : (app()->getLocale() === 'en' ? 'Browse Partners' : 'الشركاء والرعاة') }}
                    </button>
                </div>
            </div>
        @endif

    </div>
</div>
