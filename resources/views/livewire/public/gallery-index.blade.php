@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="py-12" x-data="{ activePhotoIndex: 0, photos: [] }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Header with Glassmorphism Effect -->
        <div class="relative rounded-[36px] overflow-hidden bg-slate-950/80 backdrop-blur-xl text-white p-8 sm:p-14 shadow-2xl border border-white/20">
            {{-- Background Image Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/gallery_header_bg.png') }}" alt="Gallery Header Background"
                     class="w-full h-full object-cover object-center opacity-35 transform scale-105 filter blur-xs">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-black/30"></div>
                <div class="absolute inset-0 bg-blue-950/30 mix-blend-overlay"></div>
            </div>

            {{-- Glassmorphism Glow Highlights --}}
            <div class="absolute -top-24 -end-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -start-24 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>

            {{-- Header Content --}}
            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-5">
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/15 backdrop-blur-xl border border-white/30 text-white text-xs font-black uppercase tracking-wider shadow-lg">
                    <svg class="w-4 h-4 text-sky-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $t('معرض الصور والتغطيات الميدانية', 'Galerie Photos & Couverture Média', 'Photo Gallery & Field Coverage') }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ $t('ألبومات وتغطيات أولمبياد المهن', 'Albums & Couverture Média Officiels', 'Official WorldSkills Media Albums') }}
                </h1>
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    {{ $t('استعرض ألبومات الصور والتغطيات الإعلامية للمنافسات والفعاليات والورشات عبر جميع الولايات والمراكز.', 'Explorez les moments forts des compétitions, ateliers et cérémonies à travers l\'Algérie.', 'Browse competition highlights, technical workshops and ceremonies across Algeria.') }}
                </p>
            </div>
        </div>

        <!-- Official Facebook Channel / Page Banner (Glassmorphism Effect) -->
        <div class="relative rounded-3xl p-6 sm:p-8 text-white shadow-2xl bg-gradient-to-r from-blue-600/85 via-blue-700/85 to-[#06205C]/90 backdrop-blur-xl border border-white/20 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden">
            <div class="absolute -end-16 -top-16 w-64 h-64 rounded-full bg-blue-400/20 blur-2xl pointer-events-none"></div>
            
            <div class="flex items-center gap-5 relative z-10 text-[#{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                <div class="w-16 h-16 rounded-2xl bg-white/90 backdrop-blur-md text-blue-600 flex items-center justify-center font-black text-2xl shadow-xl shrink-0 border border-white">
                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </div>
                <div>
                    <span class="px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-black uppercase tracking-wider">
                        {{ $t('الصفحة الرسمية على الفيسبوك', 'Page Facebook Officielle', 'Official Facebook Page') }}
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black mt-1.5 drop-shadow">WorldSkills Algeria — Facebook @WorldSkillsAlgeria</h2>
                    <p class="text-xs text-blue-100 mt-0.5 font-medium">
                        {{ $t('تابع جميع التغطيات الميدانية بالصور المباشرة والأخبار اليومية عبر صفحتنا الرسمية على الفيسبوك.', 'Suivez toute la couverture photos et actualités quotidiennes sur Facebook.', 'Follow live photo coverage and news on our official Facebook page.') }}
                    </p>
                </div>
            </div>

            <a href="https://www.facebook.com/WorldSkillsAlgeria?locale=fr_FR" target="_blank" class="relative z-10 w-full md:w-auto px-7 py-3.5 rounded-2xl bg-white/90 hover:bg-white backdrop-blur-md text-blue-700 font-extrabold text-xs shadow-xl transition flex items-center justify-center gap-2.5 shrink-0 transform hover:-translate-y-1 border border-white">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                <span>{{ $t('زيارة الصفحة الرسمية على الفيسبوك (@WorldSkillsAlgeria)', 'Visiter la page Facebook', 'Visit Official Facebook Page') }}</span>
            </a>
        </div>

        <!-- Albums Grid with Glassmorphism Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($albums as $album)
                @php
                    $coverUrl = $album->cover_url;
                    $itemsCount = $album->mediaItems->count();
                @endphp
                <div wire:click="openAlbum({{ $album->id }})"
                     class="bg-white/80 backdrop-blur-xl rounded-[28px] overflow-hidden border border-slate-200/90 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-blue-500/40">
                    
                    {{-- Cover Image --}}
                    <div class="h-60 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $coverUrl }}" alt="{{ $album->getLocalized('title') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-black/20 group-hover:opacity-90 transition-opacity"></div>

                        {{-- Photo Count Glassmorphism Badge --}}
                        <div class="absolute top-4 start-4 px-3.5 py-1.5 rounded-full bg-black/60 backdrop-blur-xl text-white text-[11px] font-black flex items-center gap-1.5 border border-white/20 shadow-lg">
                            <svg class="w-3.5 h-3.5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $itemsCount }} {{ $t('صورة', 'Photos', 'Photos') }}</span>
                        </div>

                        {{-- Date Badge --}}
                        <div class="absolute bottom-4 start-4 text-slate-200 text-xs font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>{{ $album->published_at ? $album->published_at->format('Y-m-d') : now()->format('Y-m-d') }}</span>
                        </div>
                    </div>

                    {{-- Card Details --}}
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-base font-black text-[#06205C] group-hover:text-blue-600 transition-colors leading-snug">
                                {{ $album->getLocalized('title') }}
                            </h3>
                            @if($album->getLocalized('description'))
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $album->getLocalized('description') }}
                            </p>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-black text-blue-600 group-hover:text-blue-700">
                            <span>{{ $t('تصفح الألبوم بالكامل', 'Consulter l\'album', 'View Full Album') }}</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white/80 backdrop-blur-xl rounded-3xl p-16 text-center text-slate-400 font-bold text-sm border border-slate-200 shadow-sm space-y-3">
                    <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p>{{ $t('لا تتوفر ألبومات صور حالياً.', 'Aucun album photo disponible pour le moment.', 'No photo albums available currently.') }}</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ════ LIGHTBOX PHOTO ALBUM MODAL (GLASSMORPHISM) ════ --}}
    @if($showModal && $activeAlbum)
        <div class="fixed inset-0 z-50 bg-black/90 backdrop-blur-2xl flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
             x-data="{
                 photos: [
                     @foreach($activeAlbum->mediaItems as $item)
                         '{{ asset(ltrim($item->storage_path, '/')) }}',
                     @endforeach
                 ],
                 currentIndex: 0,
                 next() { this.currentIndex = (this.currentIndex + 1) % this.photos.length; },
                 prev() { this.currentIndex = (this.currentIndex - 1 + this.photos.length) % this.photos.length; }
             }">
            
            <div class="bg-slate-900/90 backdrop-blur-2xl rounded-3xl overflow-hidden max-w-5xl w-full shadow-2xl border border-white/20 space-y-0 relative text-white">

                {{-- Modal Header --}}
                <div class="p-5 bg-slate-950/80 backdrop-blur-md border-b border-slate-800 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-black text-white leading-tight">{{ $activeAlbum->getLocalized('title') }}</h3>
                        <p class="text-xs text-slate-400 font-medium">
                            <span x-text="currentIndex + 1"></span> / <span x-text="photos.length"></span> {{ $t('صور في الألبوم', 'Photos', 'Photos in Album') }}
                        </p>
                    </div>

                    <button wire:click="closeModal" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition border border-white/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Main Photo Viewer --}}
                <div class="relative bg-black/60 flex items-center justify-center min-h-[400px] max-h-[70vh] p-4 select-none">
                    <template x-if="photos.length > 0">
                        <img :src="photos[currentIndex]" class="max-h-[65vh] max-w-full object-contain rounded-2xl shadow-2xl transition-all duration-300 border border-white/10">
                    </template>
                    <template x-if="photos.length === 0">
                        <div class="text-slate-500 font-medium text-xs py-12">
                            {{ $t('لا تتوفر صور إضافية داخل هذا الألبوم بعد', 'Aucune photo dans cet album', 'No photos inside this album yet') }}
                        </div>
                    </template>

                    {{-- Navigation Arrows --}}
                    <template x-if="photos.length > 1">
                        <div>
                            <button @click="prev()" class="absolute start-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center transition border border-white/20 shadow-lg backdrop-blur-md">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button @click="next()" class="absolute end-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/60 hover:bg-black text-white flex items-center justify-center transition border border-white/20 shadow-lg backdrop-blur-md">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </template>
                </div>

                {{-- Thumbnail Strip --}}
                <template x-if="photos.length > 1">
                    <div class="p-4 bg-slate-950/80 backdrop-blur-md border-t border-slate-800 flex items-center gap-3 overflow-x-auto">
                        <template x-for="(photo, index) in photos" :key="index">
                            <button @click="currentIndex = index"
                                     class="w-16 h-12 rounded-xl overflow-hidden border-2 transition shrink-0"
                                     :class="currentIndex === index ? 'border-blue-500 scale-105 shadow-md' : 'border-slate-800 opacity-60 hover:opacity-100'">
                                <img :src="photo" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>
                </template>

            </div>
        </div>
    @endif
</div>
