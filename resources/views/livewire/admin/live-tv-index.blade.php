@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) {
        'fr' => $fr,
        'en' => $en,
        default => $ar
    };
@endphp

<div class="space-y-8" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Page Header -->
    <x-dashboard.page-header 
        title="{{ $t('لوحة التحكم بالبث المباشر وشاشات التلفزيون (Live TV)', 'Gestion du Direct TV & Diffusion', 'Live TV & Broadcast Management') }}"
        subtitle="{{ $t('إدارة رابط البث الحي، الأشرطة الإخبارية المتحركة، وشرائح الإعلانات والعروض على شاشات المجمع', 'Gérez le flux vidéo en direct, les annonces défilantes et les diapositives', 'Manage live stream link, ticker news announcements, and display slides') }}">
        
        <x-slot:actions>
            <a href="{{ route('live-tv') }}" target="_blank" class="px-5 py-2.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                <span>{{ $t('معاينة شاشة البث المباشر (Live TV Screen 📺)', 'Aperçu Écran Direct TV 📺', 'Preview Live TV Screen 📺') }}</span>
            </a>
        </x-slot:actions>
    </x-dashboard.page-header>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center gap-2 shadow-xs">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- 1. LIVE STREAM CONFIGURATION SECTION -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center font-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('إعدادات قناة البث المباشر (Live Stream Source & Player)', 'Source du Flux vidéo en Direct', 'Live Stream Video Source') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قم بإدخال رابط البث الحي (YouTube Live / HLS Embed) ليظهر مباشرة في شاشة العرض والمنصة', 'Entrez l\'URL du flux en direct (YouTube Live / HLS Embed)', 'Enter the live stream URL (YouTube Live / HLS Embed)') }}
                    </p>
                </div>
            </div>

            <!-- Stream Status Badge Toggle -->
            <div class="flex items-center gap-3 bg-slate-50 px-4 py-2 rounded-2xl border border-slate-200">
                <span class="text-xs font-bold text-slate-700">
                    {{ $t('حالة البث المباشر:', 'Statut du Direct :', 'Live Status:') }}
                </span>
                <button type="button" 
                        wire:click="$set('liveStreamIsActive', !{{ $liveStreamIsActive ? 'true' : 'false' }})" 
                        class="px-3 py-1 rounded-xl text-xs font-black transition flex items-center gap-1.5 {{ $liveStreamIsActive ? 'bg-emerald-500 text-white shadow-xs' : 'bg-slate-300 text-slate-700' }}">
                    <span class="w-2 h-2 rounded-full {{ $liveStreamIsActive ? 'bg-white animate-pulse' : 'bg-slate-500' }}"></span>
                    <span>{{ $liveStreamIsActive ? $t('البث مفعّل ومباشر', 'Direct Actif', 'Live Active') : $t('البث متوقف مؤقتاً', 'Inactif', 'Inactive') }}</span>
                </button>
            </div>
        </div>

        <form wire:submit.prevent="saveStreamSettings" class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <div class="md:col-span-8 space-y-2">
                <label class="block text-xs font-bold text-slate-700">
                    {{ $t('رابط البث المباشر (YouTube Live Embed URL / Video URL)', 'URL du Flux vidéo en Direct', 'Live Stream Embed URL') }} *
                </label>
                <input type="url" 
                       wire:model="liveStreamUrl" 
                       placeholder="https://www.youtube.com/embed/live_stream_id أو https://..." 
                       class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition shadow-sm">
                <span class="text-[10px] text-slate-500 block">
                    {{ $t('مثال لروابط YouTube Live: https://www.youtube.com/embed/5qap5aO4i9A', 'Exemple URL YouTube Embed: https://www.youtube.com/embed/...', 'Example YouTube Embed URL: https://www.youtube.com/embed/...') }}
                </span>
            </div>

            <div class="md:col-span-4 space-y-2">
                <label class="block text-xs font-bold text-slate-700">
                    {{ $t('عنوان البث المباشر الرئيسي', 'Titre du Flux Direct', 'Stream Title') }}
                </label>
                <input type="text" 
                       wire:model="liveStreamTitle" 
                       placeholder="البث المباشر للأولمبياد الوطنية 2026" 
                       class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-rose-500 focus:bg-white transition shadow-sm">
            </div>

            <div class="md:col-span-12 flex justify-end">
                <button type="submit" class="px-7 py-3 rounded-2xl bg-[#06205C] hover:bg-blue-950 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $t('حفظ إعدادات البث المباشر', 'Enregistrer le Flux', 'Save Stream Settings') }}</span>
                </button>
            </div>
        </form>
    </div>

    <!-- 2. TICKER ANNOUNCEMENTS SECTION -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center font-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('شريط الأخبار والإعلانات المتحركة (Ticker News)', 'Bandeau Défilant des Nouvelles', 'Live Ticker News Announcements') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('إضافة وتعديل الأخبار العاجلة التي تتحرك في أسفل شاشة التلفزيون والمنصة', 'Ajouter et gérer les annonces défilantes en bas de l\'écran', 'Add and manage live ticker announcements moving across the bottom') }}
                    </p>
                </div>
            </div>

            <button type="button" 
                    wire:click="openAnnouncementModal" 
                    class="px-5 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $t('إضافة خبر متحرك جديد', 'Nouvelle Annonce', 'Add New Ticker News') }}</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 font-black border-b border-slate-200">
                        <th class="p-3.5 text-center">#</th>
                        <th class="p-3.5">{{ $t('نص الخبر بالعربية', 'Texte Arabe', 'Arabic News Text') }}</th>
                        <th class="p-3.5">{{ $t('نص الخبر بالفرنسية', 'Texte Français', 'French News Text') }}</th>
                        <th class="p-3.5 text-center">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="p-3.5 text-center">{{ $t('الإجراءات', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($announcements as $ann)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-3.5 text-center font-bold text-slate-400">{{ $loop->iteration }}</td>
                            <td class="p-3.5 font-bold text-[#06205C] max-w-xs truncate">{{ $ann->ticker_text_ar }}</td>
                            <td class="p-3.5 font-mono text-slate-600 max-w-xs truncate" dir="ltr">{{ $ann->ticker_text_fr ?: '—' }}</td>
                            <td class="p-3.5 text-center">
                                <button type="button" 
                                        wire:click="toggleAnnouncementStatus({{ $ann->id }})" 
                                        class="px-3 py-1 rounded-xl text-[11px] font-bold transition {{ $ann->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $ann->is_active ? $t('نشط', 'Actif', 'Active') : $t('معطل', 'Inactif', 'Disabled') }}
                                </button>
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" wire:click="openAnnouncementModal({{ $ann->id }})" class="p-2 rounded-xl bg-slate-100 hover:bg-blue-100 text-blue-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <button type="button" wire:confirm="هل أنت تأكد من حذف هذا الخبر؟" wire:click="deleteAnnouncement({{ $ann->id }})" class="p-2 rounded-xl bg-slate-100 hover:bg-rose-100 text-rose-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400 font-bold">
                                {{ $t('لا توجد أخبار متحركة مضافة حالياً.', 'Aucune annonce défilante.', 'No ticker news announcements added yet.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. SLIDES & PROMOS MANAGEMENT SECTION -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200/80 space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('شرائح العرض والإعلانات الفلكية (Live TV Slides)', 'Diapositives et Visuels de Diffusion', 'Live TV Presentation Slides') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('إدارة الصور الترويجية وإعلانات الرعاة وشاشات التوقف الدورية', 'Gérez les visuels et les diapositives de présentation', 'Manage promo slides, sponsor ads, and presentation displays') }}
                    </p>
                </div>
            </div>

            <button type="button" 
                    wire:click="openSlideModal" 
                    class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>{{ $t('إضافة شريحة عرض جديدة', 'Nouvelle Diapositive', 'Add New Display Slide') }}</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($slides as $slide)
                <div class="rounded-3xl border border-slate-200 bg-slate-50/50 p-5 space-y-4 relative overflow-hidden shadow-xs hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-wider {{ $slide->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ $slide->is_active ? $t('معروضة', 'Active', 'Active') : $t('مخفية', 'Masquée', 'Hidden') }}
                        </span>
                        <span class="text-xs font-mono font-bold text-slate-500">
                            ⏱️ {{ $slide->display_duration_sec }}s
                        </span>
                    </div>

                    @if($slide->image_url)
                        <div class="w-full h-36 rounded-2xl overflow-hidden bg-slate-200 border border-slate-300">
                            <img src="{{ $slide->image_url }}" alt="{{ $slide->title_ar }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="space-y-1">
                        <h4 class="text-sm font-black text-[#06205C] truncate">{{ $slide->title_ar }}</h4>
                        @if($slide->content)
                            <p class="text-xs text-slate-500 line-clamp-2 font-medium">{{ $slide->content }}</p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-slate-200/80 flex items-center justify-between">
                        <button type="button" wire:click="toggleSlideStatus({{ $slide->id }})" class="text-xs font-bold text-blue-600 hover:underline">
                            {{ $slide->is_active ? $t('إلغاء التفعيل', 'Désactiver', 'Deactivate') : $t('تفعيل', 'Activer', 'Activate') }}
                        </button>

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click="openSlideModal({{ $slide->id }})" class="p-1.5 rounded-lg bg-white border border-slate-200 text-blue-600 hover:bg-blue-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button type="button" wire:confirm="هل أنت تأكد من حذف هذه الشريحة؟" wire:click="deleteSlide({{ $slide->id }})" class="p-1.5 rounded-lg bg-white border border-slate-200 text-rose-600 hover:bg-rose-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-8 text-center text-slate-400 font-bold bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    {{ $t('لا توجد شرائح عرض مضافة حالياً.', 'Aucune diapositive de présentation.', 'No presentation slides added yet.') }}
                </div>
            @endforelse
        </div>
    </div>

    <!-- ANNOUNCEMENT MODAL -->
    @if($showAnnouncementModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $editingAnnouncementId ? $t('تعديل الخبر المتحرك', 'Modifier l\'Annonce', 'Edit Ticker News') : $t('إضافة خبر متحرك جديد', 'Nouvelle Annonce', 'Add New Ticker News') }}
                    </h3>
                    <button type="button" wire:click="$set('showAnnouncementModal', false)" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <form wire:submit.prevent="saveAnnouncement" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">{{ $t('نص الخبر بالعربية *', 'Texte en Arabe *', 'Arabic Text *') }}</label>
                        <textarea wire:model="tickerTextAr" required rows="3" placeholder="أدخل نص الخبر المتحرك بالعربية..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
                        @error('tickerTextAr') <span class="text-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">{{ $t('نص الخبر بالفرنسية (اختياري)', 'Texte en Français (Optionnel)', 'French Text (Optional)') }}</label>
                        <textarea wire:model="tickerTextFr" rows="3" placeholder="Texte de l'annonce en français..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500" dir="ltr"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="$set('showAnnouncementModal', false)" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-700 text-xs font-bold">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-2xl bg-brand-500 text-white text-xs font-black shadow-md">{{ $t('حفظ الخبر', 'Enregistrer', 'Save Announcement') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- SLIDE MODAL -->
    @if($showSlideModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $editingSlideId ? $t('تعديل الشريحة', 'Modifier la Diapositive', 'Edit Slide') : $t('إضافة شريحة جديدة', 'Nouvelle Diapositive', 'Add New Slide') }}
                    </h3>
                    <button type="button" wire:click="$set('showSlideModal', false)" class="text-slate-400 hover:text-slate-600">✕</button>
                </div>

                <form wire:submit.prevent="saveSlide" class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">{{ $t('عنوان الشريحة بالعربية *', 'Titre en Arabe *', 'Arabic Title *') }}</label>
                        <input type="text" wire:model="slideTitleAr" required placeholder="عنوان الشريحة..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C]">
                        @error('slideTitleAr') <span class="text-xs text-rose-600 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">{{ $t('رابط الصورة الإعلانية (Image URL)', 'URL de l\'image', 'Image URL') }}</label>
                        <input type="url" wire:model="slideImageUrl" placeholder="https://..." class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">{{ $t('مدة العرض بالثواني (Display Duration in Sec)', 'Durée en secondes', 'Duration in Seconds') }} *</label>
                        <input type="number" wire:model="slideDurationSec" required min="3" max="120" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C]">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="$set('showSlideModal', false)" class="px-5 py-2.5 rounded-2xl bg-slate-100 text-slate-700 text-xs font-bold">{{ $t('إلغاء', 'Annuler', 'Cancel') }}</button>
                        <button type="submit" class="px-6 py-2.5 rounded-2xl bg-amber-500 text-white text-xs font-black shadow-md">{{ $t('حفظ الشريحة', 'Enregistrer', 'Save Slide') }}</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
