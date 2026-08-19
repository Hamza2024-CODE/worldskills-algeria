<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                {{ app()->getLocale() === 'fr' ? 'Centre Média & Couverture Presse' : (app()->getLocale() === 'en' ? 'Media & Press Control Center' : 'لوحة إدارة الإعلام والأخبار والمحتوى الرقمي') }}
            </h1>
            <p class="text-xs font-bold text-slate-500 mt-1">
                {{ app()->getLocale() === 'fr' ? 'Gestion des articles, galeries photos, vidéos et annonces officielles.' : (app()->getLocale() === 'en' ? 'Manage news articles, photo galleries, video feeds, and announcements.' : 'لوحة إدارة الإعلام والأخبار والمحتوى الرقمي — إدارة المقالات ومعارض الصور والفيديوهات.') }}
            </p>
        </div>
        <a href="{{ route('admin.cms.homepage') }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs transition touch-target inline-flex items-center gap-2 self-start sm:self-auto">
            <span>{{ app()->getLocale() === 'fr' ? 'Nouveau Contenu' : (app()->getLocale() === 'en' ? 'Publish Content' : 'إضافة مقال جديد') }}</span>
        </a>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Articles Publiés' : (app()->getLocale() === 'en' ? 'News Articles' : 'المقالات المنشورة')" 
            :value="$newsCount" 
            badge="CMS Active" 
            color="blue" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Événements' : (app()->getLocale() === 'en' ? 'Events' : 'التظاهرات والأحداث')" 
            :value="$eventsCount" 
            badge="Calendar" 
            color="emerald" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Albums Photos' : (app()->getLocale() === 'en' ? 'Photo Albums' : 'ألبومات المعرض')" 
            :value="$albumsCount" 
            badge="Gallery" 
            color="purple" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Vidéos' : (app()->getLocale() === 'en' ? 'Videos' : 'مكتبة الفيديوهات')" 
            :value="$videosCount" 
            badge="Video Center" 
            color="amber" />
    </div>

    <!-- Media Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="text-sm font-black text-slate-900">
                {{ app()->getLocale() === 'fr' ? 'Gestionnaire CMS Articles' : (app()->getLocale() === 'en' ? 'CMS Article Manager' : 'محرر الأخبار والتغطيات') }}
            </h3>
            <p class="text-xs font-bold text-slate-500 leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Rédigez, modifiez et traduisez des articles en trois langues (Arabe, Français, Anglais).' : (app()->getLocale() === 'en' ? 'Draft, edit, and translate news articles in 3 languages.' : 'تحرير الأخبار الرسمية وتصنيفها ونشرها باللغات الثلاث (العربية، الفرنسية، الإنجليزية) عبر الهيكل المعياري.') }}
            </p>
            <a href="{{ route('admin.cms.homepage') }}" class="inline-flex items-center gap-2 text-xs font-black text-brand-600 hover:text-brand-700">
                <span>{{ app()->getLocale() === 'fr' ? 'Accéder au CMS' : (app()->getLocale() === 'en' ? 'Open CMS' : 'الانتقال إلى محرر الأخبار') }} &rarr;</span>
            </a>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4 border-2 border-rose-200 bg-rose-50/30">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black text-rose-900 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-600 animate-ping"></span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Direct TV & Diffusion' : (app()->getLocale() === 'en' ? 'Live TV & Stream Control' : 'البث المباشر وشاشات التلفزيون (Live TV)') }}</span>
                </h3>
                <span class="px-2.5 py-1 rounded-xl bg-rose-600 text-white font-black text-[10px] uppercase">Live Broadcast</span>
            </div>
            <p class="text-xs font-bold text-slate-600 leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Contrôlez le flux vidéo en direct, les annonces défilantes et les visuels de présentation.' : (app()->getLocale() === 'en' ? 'Control live video stream URL, ticker announcements, and promo presentation slides.' : 'التحكم المباشر في قناة البث الحي، إضافة وتعديل الأخبار العاجلة المتحركة، وشرائح الإعلانات والعروض على شاشات التلفزيون.') }}
            </p>
            <a href="{{ route('admin.live-tv') }}" class="inline-flex items-center gap-2 text-xs font-black text-rose-600 hover:text-rose-700">
                <span>{{ app()->getLocale() === 'fr' ? 'Gérer le Direct TV' : (app()->getLocale() === 'en' ? 'Manage Live TV' : 'الانتقال إلى لوحة البث المباشر') }} &rarr;</span>
            </a>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="text-sm font-black text-slate-900">
                {{ app()->getLocale() === 'fr' ? 'Médiathèque et Galerie' : (app()->getLocale() === 'en' ? 'Media Library & Gallery' : 'مكتبة الصور والفيديوهات') }}
            </h3>
            <p class="text-xs font-bold text-slate-500 leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Téléversez des visuels officiels et des vidéos de haute qualité sans compromettre les performances.' : (app()->getLocale() === 'en' ? 'Upload media assets and high quality video feeds.' : 'رفع الصور الرسمية وإدارة ألبومات التخصصات والفيديوهات وتحديد المعاينات الفنية للتظاهرة.') }}
            </p>
            <span class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-600">
                <span>MySQL Asset Protection</span>
            </span>
        </div>
    </div>
</div>
