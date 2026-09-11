@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="py-12" x-data="{ activeEmbedUrl: '', activeTitle: '', activeDesc: '', showModal: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Header with Glassmorphism Effect -->
        <div class="relative rounded-[36px] overflow-hidden bg-slate-950/80 backdrop-blur-xl text-white p-8 sm:p-14 shadow-2xl border border-white/20">
            {{-- Background Image Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/channels4_banner.jpg') }}" alt="WorldSkills Algeria Channel Banner"
                     class="w-full h-full object-cover object-center opacity-35 transform scale-105 filter blur-xs">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-black/30"></div>
                <div class="absolute inset-0 bg-blue-950/30 mix-blend-overlay"></div>
            </div>

            {{-- Glassmorphism Glow Highlights --}}
            <div class="absolute -top-24 -end-24 w-96 h-96 rounded-full bg-red-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -start-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>

            {{-- Header Content --}}
            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-5">
                <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/15 backdrop-blur-xl border border-white/30 text-white text-xs font-black uppercase tracking-wider shadow-lg">
                    <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $t('مركز الفيديوهات والبث المباشر', 'Centre Vidéos & Direct', 'Video Center & Live Streams') }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ $t('فيديوهات وبث أولمبياد المهن المباشرة من يوتيوب', 'Vidéos & Couverture Média Directe', 'WorldSkills Videos & Media Coverage') }}
                </h1>
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    {{ $t('انقر على أي فيديو لمشاهدته مباشرة من القناة الرسمية داخل المنصة بدقة عالية.', 'Regardez les reportages vidéo et directes depuis la chaîne officielle.', 'Watch live video streams and competition highlights directly from YouTube.') }}
                </p>
            </div>
        </div>

        <!-- Official YouTube Channel Banner (Glassmorphism Effect) -->
        <div class="relative rounded-3xl p-6 sm:p-8 text-white shadow-2xl bg-gradient-to-r from-red-600/85 via-red-700/85 to-[#06205C]/90 backdrop-blur-xl border border-white/20 flex flex-col md:flex-row items-center justify-between gap-6 overflow-hidden">
            <div class="absolute -end-16 -top-16 w-64 h-64 rounded-full bg-red-400/20 blur-2xl pointer-events-none"></div>

            <div class="flex items-center gap-5 relative z-10 text-[#{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                <div class="w-16 h-16 rounded-2xl bg-white/90 backdrop-blur-md text-red-600 flex items-center justify-center font-black text-2xl shadow-xl shrink-0 border border-white">
                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </div>
                <div>
                    <span class="px-3.5 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-[10px] font-black uppercase tracking-wider">
                        {{ $t('القناة الرسمية المعتمدة', 'Chaîne Officielle', 'Official YouTube Channel') }}
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black mt-1.5 drop-shadow">WorldSkills Algeria — @WorldSkillsAlgeria</h2>
                    <p class="text-xs text-red-100 mt-0.5 font-medium">
                        {{ $t('جميع الفيديوهات مربوطة بقاعدة البيانات وتعمل مباشرة عبر مشغل اليوتيوب بالمنصة.', 'Toutes les vidéos sont liées à la base de données et diffusées directement.', 'All videos are linked to the database and streamed directly from YouTube.') }}
                    </p>
                </div>
            </div>

            <a href="https://www.youtube.com/@WorldSkillsAlgeria/videos" target="_blank" class="relative z-10 w-full md:w-auto px-7 py-3.5 rounded-2xl bg-white/90 hover:bg-white backdrop-blur-md text-red-600 font-extrabold text-xs shadow-xl transition flex items-center justify-center gap-2.5 shrink-0 transform hover:-translate-y-1 border border-white">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                <span>{{ $t('زيارة قائمة فيديوهات القناة (@WorldSkillsAlgeria/videos)', 'Visiter les Vidéos YouTube', 'Visit YouTube Videos (@WorldSkillsAlgeria/videos)') }}</span>
            </a>
        </div>

        <!-- Video Grid (2 Columns Glassmorphism Layout) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
            @forelse($videos as $video)
                @php
                    $thumbUrl = $video->thumbnail_url;
                    $embedUrl = $video->formatted_embed_url;
                    $titleStr = addslashes($video->getLocalized('title'));
                    $descStr  = addslashes($video->getLocalized('description'));
                @endphp
                <div @click="activeEmbedUrl = '{{ $embedUrl }}'; activeTitle = '{{ $titleStr }}'; activeDesc = '{{ $descStr }}'; showModal = true;"
                     class="bg-white/80 backdrop-blur-xl rounded-[28px] overflow-hidden border border-slate-200/90 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-blue-500/40">
                    
                    {{-- Thumbnail Layer --}}
                    <div class="h-64 sm:h-72 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" alt="{{ $video->getLocalized('title') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-black/10 group-hover:opacity-90 transition-opacity"></div>

                        {{-- Bright Electric Blue Play Button Overlay --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0066FF] hover:bg-[#0052CC] text-white flex items-center justify-center shadow-2xl shadow-blue-500/60 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        {{-- Duration Glassmorphism Badge (Bottom-Right) --}}
                        <div class="absolute bottom-4 end-4 px-3.5 py-1.5 rounded-full bg-black/75 backdrop-blur-xl text-white text-xs font-mono font-bold flex items-center gap-1.5 border border-white/20 shadow-lg">
                            <span>{{ is_numeric($video->duration) ? gmdate("i:s", (int)$video->duration) : ($video->duration ?: '04:15') }}</span>
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        {{-- Video Type Glassmorphism Badge (Top-Start) --}}
                        <div class="absolute top-4 start-4 px-4 py-1.5 rounded-full bg-[#0066FF]/90 backdrop-blur-md text-white text-[11px] font-black uppercase tracking-wider shadow-md border border-white/30">
                            {{ strtoupper($video->video_type ?: 'YOUTUBE') }}
                        </div>
                    </div>

                    {{-- Content Details --}}
                    <div class="p-6 sm:p-8 space-y-4 flex-1 flex flex-col justify-between text-center">
                        <div class="space-y-3">
                            <h3 class="text-lg sm:text-xl font-black text-[#06205C] group-hover:text-[#0066FF] transition-colors leading-snug">
                                {{ $video->getLocalized('title') }}
                            </h3>
                            @if($video->getLocalized('description'))
                            <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $video->getLocalized('description') }}
                            </p>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-extrabold text-[#0066FF] group-hover:text-[#0052CC]">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>

                            <span class="flex items-center gap-2">
                                <span>{{ $t('مشاهدة الفيديو المباشر من يوتيوب', 'Regarder la vidéo', 'Watch YouTube Stream') }}</span>
                                <div class="w-6 h-6 rounded-full bg-blue-50 text-[#0066FF] flex items-center justify-center border border-blue-100">
                                    <svg class="w-3.5 h-3.5 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white/80 backdrop-blur-xl rounded-3xl p-16 text-center text-slate-400 font-bold text-sm border border-slate-200 shadow-sm space-y-3">
                    <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p>{{ $t('لا تتوفر فيديوهات حالياً.', 'Aucune vidéo disponible pour le moment.', 'No videos available currently.') }}</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ════ INSTANT ALPINE.JS YOUTUBE PLAYER MODAL (GLASSMORPHISM) ════ --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 bg-black/90 backdrop-blur-2xl flex items-center justify-center p-4 sm:p-6">
        <div @click.away="showModal = false; activeEmbedUrl = '';" class="bg-slate-900/90 backdrop-blur-2xl rounded-3xl overflow-hidden max-w-4xl w-full shadow-2xl border border-white/20 space-y-0 relative text-white">

            {{-- Modal Header --}}
            <div class="p-5 bg-slate-950/80 backdrop-blur-md border-b border-slate-800 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-base sm:text-lg font-black text-white leading-tight" x-text="activeTitle"></h3>
                    <p class="text-xs text-slate-400 font-medium mt-0.5" x-text="activeDesc"></p>
                </div>

                <button @click="showModal = false; activeEmbedUrl = '';" class="w-10 h-10 rounded-full bg-slate-800 hover:bg-slate-700 text-white flex items-center justify-center transition border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Instant Direct YouTube Player Container --}}
            <div class="aspect-video w-full bg-black relative">
                <template x-if="showModal && activeEmbedUrl">
                    <iframe class="w-full h-full border-0"
                            :src="activeEmbedUrl"
                            title="YouTube Video Player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </template>
            </div>

        </div>
    </div>
</div>
