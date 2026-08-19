<div class="space-y-6 pb-8">

    {{-- FLASH MESSAGES --}}
    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-900 dark:text-rose-200 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">إدارة مكتبة الفيديو والتغطيات</h1>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">
                        إجمالي مقاطع الفيديو: <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $totalVideos }}</span> فيديو
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="syncFromChannel" wire:loading.attr="disabled"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-black transition shadow-sm shrink-0 disabled:opacity-50">
                <svg wire:loading.remove wire:target="syncFromChannel" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                <svg wire:loading wire:target="syncFromChannel" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span>جاري الاستيراد...</span>
                <span wire:loading.remove wire:target="syncFromChannel">استيراد تلقائي من القناة (@WorldSkillsAlgeria)</span>
            </button>

            <button wire:click="openCreate"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>إضافة فيديو جديد</span>
            </button>
        </div>
    </div>

    {{-- SEARCH & FILTERS BAR --}}
    <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="بحث بالرابط أو عنوان الفيديو..."
                class="w-full pl-3 pr-10 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            <svg class="w-4 h-4 absolute right-3.5 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <select wire:model.live="filterType" class="px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                <option value="">جميع الأنواع (كل المشغلات)</option>
                <option value="YOUTUBE">YouTube</option>
                <option value="VIMEO">Vimeo</option>
                <option value="MP4">MP4 مباشر</option>
                <option value="HLS">HLS Stream</option>
                <option value="EMBED">تضمين Embed</option>
            </select>

            <select wire:model.live="filterStatus" class="px-3 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                <option value="">جميع الحالات</option>
                <option value="PUBLISHED">منشور</option>
                <option value="DRAFT">مسودة</option>
            </select>
        </div>
    </div>

    {{-- VIDEOS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-3xl p-4 shadow-xs hover:shadow-lg transition flex flex-col justify-between group overflow-hidden">
                <div>
                    {{-- Thumbnail & Badges --}}
                    <div class="relative w-full h-44 rounded-2xl bg-slate-900 overflow-hidden mb-3 group-hover:shadow-md transition">
                        <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title_ar }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300 opacity-90 group-hover:opacity-100">
                        <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition flex items-center justify-center">
                            <button wire:click="openDrawer({{ $video->id }})" class="w-12 h-12 rounded-full bg-blue-600/90 text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition">
                                <svg class="w-6 h-6 ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </button>
                        </div>
                        <div class="absolute top-2 right-2 flex items-center gap-1.5">
                            @if($video->status === 'PUBLISHED')
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-emerald-500 text-white shadow-xs">منشور</span>
                            @else
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-amber-500 text-white shadow-xs">مسودة</span>
                            @endif
                            @if($video->is_featured)
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-indigo-600 text-white shadow-xs">مميز</span>
                            @endif
                        </div>
                        <div class="absolute bottom-2 left-2">
                            <span class="px-2 py-0.5 rounded-md text-[10px] font-mono font-bold bg-black/70 text-white backdrop-blur-xs">{{ $video->video_type }}</span>
                        </div>
                    </div>

                    {{-- Title & URL --}}
                    <h3 class="font-black text-slate-900 dark:text-slate-100 text-base line-clamp-1 mb-1" title="{{ $video->title_ar }}">{{ $video->title_ar }}</h3>
                    @if($video->title_fr)
                        <p class="text-xs text-slate-400 font-medium line-clamp-1 mb-2" title="{{ $video->title_fr }}">{{ $video->title_fr }}</p>
                    @endif
                    <p class="text-[11px] font-mono text-slate-500 dark:text-slate-400 line-clamp-1 mb-4 bg-slate-50 dark:bg-slate-900/50 px-2 py-1 rounded-lg border border-slate-100 dark:border-slate-800 dir-ltr text-left">{{ $video->video_url }}</p>
                </div>

                {{-- Card Footer --}}
                <div class="flex justify-between items-center text-xs font-bold pt-3 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-slate-400 text-[11px]">{{ $video->duration ? $video->duration : '—' }}</span>
                    <div class="flex items-center gap-1">
                        <button wire:click="openDrawer({{ $video->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition" title="معاينة الفيديو">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                        <button wire:click="openEdit({{ $video->id }})" class="p-1.5 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-lg transition" title="تعديل">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button wire:click="confirmDelete({{ $video->id }})" class="p-1.5 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg transition" title="حذف">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs">
                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <p class="text-sm font-bold text-slate-600 dark:text-slate-300 mb-1">لا توجد مقاطع فيديو مطابقة للبحث</p>
                <p class="text-xs text-slate-400">يمكنك إضافة فيديو جديد أو الاستيراد من القناة الرسمية</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($videos->hasPages())
        <div class="pt-4">
            {{ $videos->links() }}
        </div>
    @endif

    {{-- MODAL FORM (CREATE / EDIT VIDEO) --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل بيانات الفيديو' : 'إضافة فيديو جديد' }}</h3>
                    <button wire:click="closeForm" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                <div class="space-y-3 text-xs font-semibold">
                    {{-- Title AR --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">عنوان الفيديو (بالعربية) *</label>
                        <input wire:model="title_ar" type="text" placeholder="مثال: التغطية المباشرة للأولمبياد الوطنية..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border @error('title_ar') border-rose-500 @else border-slate-200 dark:border-slate-600 @enderror bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        @error('title_ar') <span class="text-rose-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Title FR --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">عنوان الفيديو (بالفرنسية) *</label>
                        <input wire:model="title_fr" type="text" placeholder="Ex: Couverture vidéo officielle..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border @error('title_fr') border-rose-500 @else border-slate-200 dark:border-slate-600 @enderror bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        @error('title_fr') <span class="text-rose-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Title EN --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">عنوان الفيديو (بالإنجليزية - اختياري)</label>
                        <input wire:model="title_en" type="text" placeholder="Ex: Official trade competition..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                    </div>

                    {{-- Grid 2 col: Video Type & Status --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">نوع المشغل (Video Type) *</label>
                            <select wire:model="video_type" class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                                <option value="YOUTUBE">YouTube</option>
                                <option value="VIMEO">Vimeo</option>
                                <option value="MP4">MP4 (ملف مباشر)</option>
                                <option value="HLS">HLS Stream</option>
                                <option value="EMBED">تضمين iframe</option>
                            </select>
                            @error('video_type') <span class="text-rose-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">حالة النشر *</label>
                            <select wire:model="status" class="w-full px-3.5 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100">
                                <option value="PUBLISHED">منشور علنياً</option>
                                <option value="DRAFT">مسودة (مخفي)</option>
                            </select>
                        </div>
                    </div>

                    {{-- Video URL --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">رابط الفيديو (URL) *</label>
                        <input wire:model="video_url" type="url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border @error('video_url') border-rose-500 @else border-slate-200 dark:border-slate-600 @enderror bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-mono text-left dir-ltr">
                        @error('video_url') <span class="text-rose-500 text-[11px] font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    {{-- Embed URL --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">رابط التضمين (Embed URL - يُولّد تلقائياً لـ YouTube)</label>
                        <input wire:model="embed_url" type="url" placeholder="https://www.youtube.com/embed/..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-mono text-left dir-ltr">
                    </div>

                    {{-- Duration & Is Featured --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-center">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">المدة (مثل 03:45)</label>
                            <input wire:model="duration" type="text" placeholder="03:45" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>

                        <div class="pt-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input wire:model="is_featured" type="checkbox" class="w-4 h-4 rounded-md text-blue-600 focus:ring-blue-500 border-slate-300">
                                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">عرض كـ فيديو مميز ⭐</span>
                            </label>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">وصف أو تفاصيل الفيديو</label>
                        <textarea wire:model="description_ar" rows="3" placeholder="اكتب نبذة أو وصف مختصر للفيديو..." class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100"></textarea>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="closeForm" type="button" class="px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition">إلغاء</button>
                    <button wire:click="save" wire:loading.attr="disabled" type="button" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition flex items-center gap-2 disabled:opacity-50">
                        <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>{{ $isEditing ? 'حفظ التعديلات' : 'إضافة الفيديو' }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELETE CONFIRMATION MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-md w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl text-center">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100 mb-1">تأكيد حذف الفيديو</h3>
                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">هل أنت متاكد من رغبتك في حذف هذا الفيديو نهائياً من المكتبة؟ لا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="cancelDelete" class="px-5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold hover:bg-slate-200 transition">إلغاء</button>
                    <button wire:click="deleteVideo" wire:loading.attr="disabled" class="px-6 py-2.5 rounded-xl bg-rose-600 text-white text-xs font-black hover:bg-rose-700 shadow-xs transition flex items-center gap-2 disabled:opacity-50">
                        <svg wire:loading wire:target="deleteVideo" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>نعم، إحذف الفيديو</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- PREVIEW DRAWER / MODAL --}}
    @if($drawerOpen && $selectedVideo)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-2xl w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-y-auto max-h-[95vh]">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 mb-1 inline-block">{{ $selectedVideo->video_type }}</span>
                        <h3 class="text-base font-black text-slate-900 dark:text-slate-100">{{ $selectedVideo->title_ar }}</h3>
                    </div>
                    <button wire:click="closeDrawer" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>

                {{-- Player embed --}}
                <div class="relative w-full aspect-video rounded-2xl bg-black overflow-hidden shadow-inner border border-slate-200 dark:border-slate-700">
                    <iframe src="{{ $selectedVideo->formatted_embed_url }}" class="w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>

                {{-- Metadata details --}}
                <div class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                    @if($selectedVideo->title_fr)
                        <p><strong class="text-slate-900 dark:text-slate-100">العنوان بالفرنسية:</strong> {{ $selectedVideo->title_fr }}</p>
                    @endif
                    @if($selectedVideo->description_ar)
                        <p><strong class="text-slate-900 dark:text-slate-100">الوصف:</strong> {{ $selectedVideo->description_ar }}</p>
                    @endif
                    <div class="flex flex-wrap gap-4 pt-2 border-t border-slate-100 dark:border-slate-700 text-[11px] font-bold">
                        <span>المدة: {{ $selectedVideo->duration ?: 'غير محددة' }}</span>
                        <span>الحالة: {{ $selectedVideo->status === 'PUBLISHED' ? 'منشور' : 'مسودة' }}</span>
                        <span>تاريخ النشر: {{ $selectedVideo->published_at ? $selectedVideo->published_at->format('Y-m-d H:i') : 'غير منشور' }}</span>
                    </div>
                    <p class="pt-1 text-[11px] font-mono text-slate-400 truncate dir-ltr text-left">URL: {{ $selectedVideo->video_url }}</p>
                </div>

                <div class="flex justify-between items-center pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="closeDrawer" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl transition">إغلاق المعاينة</button>
                    <button wire:click="openEdit({{ $selectedVideo->id }}); closeDrawer();" class="px-5 py-2 text-xs font-black text-white bg-amber-600 hover:bg-amber-700 rounded-xl shadow-xs transition">تعديل هذا الفيديو</button>
                </div>
            </div>
        </div>
    @endif

</div>

