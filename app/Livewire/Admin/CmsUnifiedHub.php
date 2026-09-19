<?php

namespace App\Livewire\Admin;

use App\Models\Album;
use App\Models\LegalContent;
use App\Models\LiveTvAnnouncement;
use App\Models\LiveTvSlide;
use App\Models\Media;
use App\Models\NewsArticle;
use App\Models\Video;
use App\Services\SettingsEngine;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class CmsUnifiedHub extends Component
{
    use WithPagination, WithFileUploads;

    // Active Navigation Tab
    public string $activeTab = 'dashboard';

    // Global Flash Message
    public string $flashMessage = '';
    public string $flashMessageType = 'success';

    // ----------------------------------------------------
    // HOMEPAGE CMS PROPERTIES
    // ----------------------------------------------------
    public string $hero_title_ar = '';
    public string $hero_title_fr = '';
    public string $hero_title_en = '';
    public string $hero_subtitle_ar = '';
    public string $hero_subtitle_fr = '';
    public string $hero_subtitle_en = '';
    public string $cta_text_ar = '';
    public string $cta_text_fr = '';
    public string $cta_text_en = '';

    public bool $news_ticker_enabled = true;
    public string $news_ticker_badge_ar = '';
    public string $news_ticker_badge_fr = '';
    public string $news_ticker_badge_en = '';
    public string $news_ticker_text_ar = '';
    public string $news_ticker_text_fr = '';
    public string $news_ticker_text_en = '';
    public string $news_ticker_url = '';

    public bool $registration_competitors_enabled = true;
    public bool $registration_supporters_enabled = true;
    public bool $registration_accreditation_enabled = true;
    public bool $page_partners_enabled = true;

    // Countdown Settings
    public bool $countdown_enabled = false;
    public string $countdown_title_ar = '';
    public string $countdown_target_date = '';

    // ----------------------------------------------------
    // LIVE TV PROPERTIES
    // ----------------------------------------------------
    public string $liveStreamUrl = '';
    public string $liveStreamTitle = '';
    public bool $liveStreamIsActive = true;
    public string $tickerTextAr = '';
    public string $tickerTextFr = '';

    // ----------------------------------------------------
    // NEWS CMS PROPERTIES
    // ----------------------------------------------------
    public string $newsSearch = '';
    public string $newsCategoryFilter = 'ALL';
    public string $newsStatusFilter = 'ALL';

    public bool $showNewsModal = false;
    public ?int $editingNewsId = null;
    public string $news_title_ar = '';
    public string $news_title_fr = '';
    public string $news_title_en = '';
    public string $news_category = 'ANNOUNCEMENT';
    public string $news_excerpt_ar = '';
    public string $news_content_ar = '';
    public string $news_featured_image = '';
    public string $news_status = 'PUBLISHED';

    // ----------------------------------------------------
    // VIDEOS CMS PROPERTIES
    // ----------------------------------------------------
    public string $videoSearch = '';
    public bool $showVideoModal = false;
    public ?int $editingVideoId = null;
    public string $video_title_ar = '';
    public string $video_title_fr = '';
    public string $video_type = 'YOUTUBE';
    public string $video_url = '';
    public string $video_embed_url = '';
    public string $video_description_ar = '';
    public string $video_duration = '';
    public bool $video_is_featured = false;
    public string $video_status = 'PUBLISHED';

    // ----------------------------------------------------
    // GALLERY CMS PROPERTIES
    // ----------------------------------------------------
    public string $gallerySearch = '';
    public bool $showGalleryModal = false;
    public ?int $editingAlbumId = null;
    public string $album_title_ar = '';
    public string $album_title_fr = '';
    public string $album_description_ar = '';
    public bool $album_is_featured = false;
    public string $album_status = 'PUBLISHED';
    public array $newPhotos = [];

    // ----------------------------------------------------
    // LEGAL & GUIDE CMS PROPERTIES
    // ----------------------------------------------------
    public string $legalActiveKey = 'privacy';
    public string $legal_title_ar = '';
    public string $legal_title_fr = '';
    public string $legal_title_en = '';
    public string $legal_content_ar = '';
    public string $legal_content_fr = '';
    public string $legal_content_en = '';
    public bool $legal_is_published = true;
    public string $legal_version = '1.0';

    // ----------------------------------------------------
    // APPEARANCE PROPERTIES
    // ----------------------------------------------------
    public string $site_name = '';
    public string $primary_color = '#06205C';
    public string $accent_color = '#D97706';
    public string $site_logo_url = '';
    public bool $coming_soon_mode = false;
    public string $coming_soon_title = '';

    // DELETE CONFIRMATION STATE
    public bool $showDeleteModal = false;
    public ?int $deletingItemId = null;
    public string $deletingItemType = ''; // 'NEWS', 'VIDEO', 'ALBUM', 'TV_ANNOUNCEMENT'
    public string $deletingItemTitle = '';

    protected $queryString = [
        'activeTab' => ['except' => 'dashboard'],
    ];

    public function mount(?string $tab = null): void
    {
        $routeName = request()->route()?->getName();

        if ($routeName === 'admin.cms.homepage') {
            $this->activeTab = 'homepage';
        } elseif ($routeName === 'admin.live-tv' || request()->is('*live-tv*')) {
            $this->activeTab = 'livetv';
        } elseif ($routeName === 'admin.cms.news') {
            $this->activeTab = 'news';
        } elseif ($routeName === 'admin.cms.videos') {
            $this->activeTab = 'videos';
        } elseif ($routeName === 'admin.cms.gallery') {
            $this->activeTab = 'gallery';
        } elseif ($routeName === 'admin.cms.legal') {
            $this->activeTab = 'legal';
        } elseif ($routeName === 'admin.appearance' || request()->is('*appearance*')) {
            $this->activeTab = 'appearance';
        } else {
            $this->activeTab = request()->query('activeTab', $tab ?? 'dashboard');
        }

        $this->loadHomepageSettings();
        $this->loadLiveTvSettings();
        $this->loadLegalDocument($this->legalActiveKey);
        $this->loadAppearanceSettings();
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    // --- HOMEPAGE CMS METHODS ---
    public function loadHomepageSettings(): void
    {
        $settings = app(SettingsEngine::class);

        $this->hero_title_ar = $settings->get('home_hero_title_ar', 'المنصة الوطنية للتميز ومهارات المستقبل');
        $this->hero_title_fr = $settings->get('home_hero_title_fr', 'Plateforme Nationale d’Excellence et des Métiers de l’Avenir');
        $this->hero_title_en = $settings->get('home_hero_title_en', 'National Platform for Excellence and Future Skills');

        $this->hero_subtitle_ar = $settings->get('home_hero_subtitle_ar', 'البوابة الرسمية لأولمبياد المهن الجزائرية وتنافسية الكفاءات الوطنية');
        $this->hero_subtitle_fr = $settings->get('home_hero_subtitle_fr', 'Portail Officiel des Olympiades des Métiers');
        $this->hero_subtitle_en = $settings->get('home_hero_subtitle_en', 'Official Portal for WorldSkills Algeria');

        $this->cta_text_ar = $settings->get('home_cta_text_ar', 'سجل الآن في التصفيات');
        $this->cta_text_fr = $settings->get('home_cta_text_fr', 'S’inscrire aux Épreuves');
        $this->cta_text_en = $settings->get('home_cta_text_en', 'Register for Competitions');

        $this->news_ticker_enabled  = (bool) $settings->get('news_ticker_enabled', true);
        $this->news_ticker_badge_ar = $settings->get('news_ticker_badge_ar', 'إعلان رسمي | المنتدى الإفريقي 2026');
        $this->news_ticker_text_ar  = $settings->get('news_ticker_text_ar', 'انعقاد منتدى السياسات الإفريقية للمهارات 2026 بالتزامن مع أولمبياد المهن الجزائرية — مركز المؤتمرات وهران');
        $this->news_ticker_url      = $settings->get('news_ticker_url', 'https://worldskills.dz/');

        $this->registration_competitors_enabled  = (bool) $settings->get('registration_competitors_enabled', true);
        $this->registration_supporters_enabled   = (bool) $settings->get('registration_supporters_enabled', true);
        $this->registration_accreditation_enabled = (bool) $settings->get('registration_accreditation_enabled', true);
        $this->page_partners_enabled               = (bool) $settings->get('page_partners_enabled', true);

        $this->countdown_enabled     = (bool) $settings->get('countdown_enabled', false);
        $this->countdown_title_ar    = $settings->get('countdown_title_ar', 'العد التنازلي لانطلاق الأولمبياد الوطنية 2026');
        $this->countdown_target_date = $settings->get('countdown_target_date', '2026-10-15T09:00');
    }

    public function saveHomepageSettings(): void
    {
        $settings = app(SettingsEngine::class);

        $settings->set('home_hero_title_ar', $this->hero_title_ar);
        $settings->set('home_hero_title_fr', $this->hero_title_fr);
        $settings->set('home_hero_title_en', $this->hero_title_en);

        $settings->set('home_hero_subtitle_ar', $this->hero_subtitle_ar);
        $settings->set('home_hero_subtitle_fr', $this->hero_subtitle_fr);
        $settings->set('home_hero_subtitle_en', $this->hero_subtitle_en);

        $settings->set('home_cta_text_ar', $this->cta_text_ar);
        $settings->set('home_cta_text_fr', $this->cta_text_fr);
        $settings->set('home_cta_text_en', $this->cta_text_en);

        $settings->set('news_ticker_enabled', $this->news_ticker_enabled);
        $settings->set('news_ticker_badge_ar', $this->news_ticker_badge_ar);
        $settings->set('news_ticker_text_ar', $this->news_ticker_text_ar);
        $settings->set('news_ticker_url', $this->news_ticker_url);

        $settings->set('registration_competitors_enabled', $this->registration_competitors_enabled);
        $settings->set('registration_supporters_enabled', $this->registration_supporters_enabled);
        $settings->set('registration_accreditation_enabled', $this->registration_accreditation_enabled);
        $settings->set('page_partners_enabled', $this->page_partners_enabled);

        $settings->set('countdown_enabled', $this->countdown_enabled);
        $settings->set('countdown_title_ar', $this->countdown_title_ar);
        $settings->set('countdown_target_date', $this->countdown_target_date);

        $this->flashMessage = 'تم حفظ إعدادات الصفحة الرئيسية ونوارة الأخبار بنجاح!';
        $this->flashMessageType = 'success';
    }

    // --- LIVE TV METHODS ---
    public function loadLiveTvSettings(): void
    {
        $settings = app(SettingsEngine::class);
        $this->liveStreamUrl      = $settings->get('live_stream_url', 'https://www.youtube.com/embed/live_stream');
        $this->liveStreamTitle    = $settings->get('live_stream_title', 'البث المباشر الرسمي لأولمبياد المهن الجزائرية 2026');
        $this->liveStreamIsActive = (bool) $settings->get('live_stream_is_active', true);
    }

    public function saveLiveTvSettings(): void
    {
        $settings = app(SettingsEngine::class);
        $settings->set('live_stream_url', trim($this->liveStreamUrl));
        $settings->set('live_stream_title', trim($this->liveStreamTitle));
        $settings->set('live_stream_is_active', $this->liveStreamIsActive);

        $this->flashMessage = 'تم تحديث إعدادات وقناة البث المباشر بنجاح!';
        $this->flashMessageType = 'success';
    }

    public function addLiveTvAnnouncement(): void
    {
        if (empty(trim($this->tickerTextAr))) return;

        LiveTvAnnouncement::create([
            'text_ar' => trim($this->tickerTextAr),
            'text_fr' => trim($this->tickerTextFr) ?: trim($this->tickerTextAr),
            'is_active' => true,
        ]);

        $this->tickerTextAr = '';
        $this->tickerTextFr = '';
        $this->flashMessage = 'تمت إضافة شريط خبر عاجل للبث المباشر بنجاح!';
        $this->flashMessageType = 'success';
    }

    // --- NEWS CMS METHODS ---
    public function openCreateNews(): void
    {
        $this->editingNewsId = null;
        $this->news_title_ar = '';
        $this->news_title_fr = '';
        $this->news_title_en = '';
        $this->news_category = 'ANNOUNCEMENT';
        $this->news_excerpt_ar = '';
        $this->news_content_ar = '';
        $this->news_featured_image = '';
        $this->news_status = 'PUBLISHED';
        $this->showNewsModal = true;
    }

    public function openEditNews(int $id): void
    {
        $article = NewsArticle::find($id);
        if (!$article) return;

        $this->editingNewsId = $article->id;
        $this->news_title_ar = $article->title_ar ?? '';
        $this->news_title_fr = $article->title_fr ?? '';
        $this->news_title_en = $article->title_en ?? '';
        $this->news_category = $article->category ?? 'ANNOUNCEMENT';
        $this->news_excerpt_ar = $article->excerpt_ar ?? '';
        $this->news_content_ar = $article->content_ar ?? '';
        $this->news_featured_image = $article->featured_image ?? '';
        $this->news_status = $article->status ?? 'PUBLISHED';
        $this->showNewsModal = true;
    }

    public function saveNewsArticle(): void
    {
        $this->validate([
            'news_title_ar' => 'required|string|min:3',
        ]);

        $slug = Str::slug($this->news_title_ar) ?: 'news-' . time();

        if ($this->editingNewsId) {
            $article = NewsArticle::find($this->editingNewsId);
            if ($article) {
                $article->update([
                    'title_ar'       => trim($this->news_title_ar),
                    'title_fr'       => trim($this->news_title_fr),
                    'title_en'       => trim($this->news_title_en),
                    'category'       => $this->news_category,
                    'excerpt_ar'     => trim($this->news_excerpt_ar),
                    'content_ar'     => trim($this->news_content_ar),
                    'featured_image' => trim($this->news_featured_image),
                    'status'         => $this->news_status,
                ]);
                $this->flashMessage = 'تم تعديل المقال الإخباري بنجاح!';
            }
        } else {
            NewsArticle::create([
                'uuid'           => (string) Str::uuid(),
                'slug'           => $slug,
                'title_ar'       => trim($this->news_title_ar),
                'title_fr'       => trim($this->news_title_fr),
                'title_en'       => trim($this->news_title_en),
                'category'       => $this->news_category,
                'excerpt_ar'     => trim($this->news_excerpt_ar),
                'content_ar'     => trim($this->news_content_ar),
                'featured_image' => trim($this->news_featured_image),
                'status'         => $this->news_status,
                'published_at'   => now(),
            ]);
            $this->flashMessage = 'تم نشر المقال الإخباري الجديد بنجاح!';
        }

        $this->flashMessageType = 'success';
        $this->showNewsModal = false;
    }

    // --- VIDEO CMS METHODS ---
    public function openCreateVideo(): void
    {
        $this->editingVideoId = null;
        $this->video_title_ar = '';
        $this->video_title_fr = '';
        $this->video_type = 'YOUTUBE';
        $this->video_url = '';
        $this->video_embed_url = '';
        $this->video_description_ar = '';
        $this->video_duration = '';
        $this->video_is_featured = false;
        $this->video_status = 'PUBLISHED';
        $this->showVideoModal = true;
    }

    public function openEditVideo(int $id): void
    {
        $video = Video::find($id);
        if (!$video) return;

        $this->editingVideoId = $video->id;
        $this->video_title_ar = $video->title_ar ?? '';
        $this->video_title_fr = $video->title_fr ?? '';
        $this->video_type = $video->video_type ?? 'YOUTUBE';
        $this->video_url = $video->video_url ?? '';
        $this->video_embed_url = $video->embed_url ?? '';
        $this->video_description_ar = $video->description_ar ?? '';
        $this->video_duration = $video->duration ?? '';
        $this->video_is_featured = (bool) $video->is_featured;
        $this->video_status = $video->status ?? 'PUBLISHED';
        $this->showVideoModal = true;
    }

    public function saveVideo(): void
    {
        $this->validate([
            'video_title_ar' => 'required|string|min:3',
            'video_url'      => 'required|string',
        ]);

        if ($this->editingVideoId) {
            $video = Video::find($this->editingVideoId);
            if ($video) {
                $video->update([
                    'title_ar'       => trim($this->video_title_ar),
                    'title_fr'       => trim($this->video_title_fr),
                    'video_type'     => $this->video_type,
                    'video_url'      => trim($this->video_url),
                    'embed_url'      => trim($this->video_embed_url),
                    'description_ar' => trim($this->video_description_ar),
                    'duration'       => trim($this->video_duration),
                    'is_featured'    => $this->video_is_featured,
                    'status'         => $this->video_status,
                ]);
                $this->flashMessage = 'تم تحديث الفيديو بنجاح!';
            }
        } else {
            Video::create([
                'uuid'           => (string) Str::uuid(),
                'title_ar'       => trim($this->video_title_ar),
                'title_fr'       => trim($this->video_title_fr),
                'video_type'     => $this->video_type,
                'video_url'      => trim($this->video_url),
                'embed_url'      => trim($this->video_embed_url),
                'description_ar' => trim($this->video_description_ar),
                'duration'       => trim($this->video_duration),
                'is_featured'    => $this->video_is_featured,
                'status'         => $this->video_status,
            ]);
            $this->flashMessage = 'تمت إضافة الفيديو إلى المكتبة بنجاح!';
        }

        $this->flashMessageType = 'success';
        $this->showVideoModal = false;
    }

    public function syncYouTubeChannel(): void
    {
        try {
            $importer = new \App\Services\YouTubeChannelImporterService();
            $res = $importer->importFromChannelHandle('@WorldSkillsAlgeria');
            $msg = $res['message'] ?? 'تم استيراد الفيديوهات بنجاح من قناة يوتيوب الرسمية!';
            $this->flashMessage = $msg;
            $this->flashMessageType = 'success';
        } catch (\Throwable $e) {
            $this->flashMessage = 'حدث خطأ أثناء الاتصال بقناة يوتيوب: ' . $e->getMessage();
            $this->flashMessageType = 'danger';
        }
    }

    // --- GALLERY CMS METHODS ---
    public function openCreateAlbum(): void
    {
        $this->editingAlbumId = null;
        $this->album_title_ar = '';
        $this->album_title_fr = '';
        $this->album_description_ar = '';
        $this->album_is_featured = false;
        $this->album_status = 'PUBLISHED';
        $this->newPhotos = [];
        $this->showGalleryModal = true;
    }

    public function saveAlbum(): void
    {
        $this->validate([
            'album_title_ar' => 'required|string|min:3',
        ]);

        $slug = Str::slug($this->album_title_ar) ?: 'album-' . time();

        if ($this->editingAlbumId) {
            $album = Album::find($this->editingAlbumId);
            if ($album) {
                $album->update([
                    'title_ar'       => trim($this->album_title_ar),
                    'title_fr'       => trim($this->album_title_fr),
                    'description_ar' => trim($this->album_description_ar),
                    'is_featured'    => $this->album_is_featured,
                    'status'         => $this->album_status,
                ]);
            }
        } else {
            $album = Album::create([
                'uuid'           => (string) Str::uuid(),
                'slug'           => $slug,
                'title_ar'       => trim($this->album_title_ar),
                'title_fr'       => trim($this->album_title_fr),
                'description_ar' => trim($this->album_description_ar),
                'is_featured'    => $this->album_is_featured,
                'status'         => $this->album_status,
            ]);
        }

        // Upload photos if any
        if (!empty($this->newPhotos) && isset($album)) {
            foreach ($this->newPhotos as $photo) {
                $filename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('albums', $filename, 'public');

                $media = Media::create([
                    'filename'          => $filename,
                    'original_filename' => $photo->getClientOriginalName(),
                    'mime_type'         => $photo->getMimeType(),
                    'file_size'         => $photo->getSize(),
                    'storage_path'      => 'storage/' . $path,
                    'visibility'        => 'PUBLIC',
                    'status'            => 'READY',
                ]);

                $album->mediaItems()->attach($media->id);
                if (!$album->cover_media_id) {
                    $album->update(['cover_media_id' => $media->id]);
                }
            }
        }

        $this->flashMessage = 'تم حفظ الألبوم ومعرض الصور بنجاح!';
        $this->flashMessageType = 'success';
        $this->showGalleryModal = false;
        $this->newPhotos = [];
    }

    // --- LEGAL & GUIDE METHODS ---
    public function loadLegalDocument(string $key): void
    {
        $this->legalActiveKey = $key;
        $doc = LegalContent::firstOrCreate(['key' => $key], [
            'title_ar' => $key === 'privacy' ? 'سياسة الخصوصية الرسمية' : ($key === 'terms' ? 'شروط وأحكام الاستخدام' : 'دليل القوانين والتنظيمات'),
            'title_fr' => $key === 'privacy' ? 'Politique de Confidentialité' : 'Terms of Service',
            'title_en' => $key === 'privacy' ? 'Privacy Policy' : 'Terms & Conditions',
            'content_ar' => 'تلتزم المنصة الوطنية لحماية بيانات جميع المشاركين والزوار وفق التشريعات الوطنية والتنظيمات الدولية.',
            'content_fr' => 'La plateforme nationale s\'engage à protéger les données personnelles.',
            'content_en' => 'The national platform commits to protecting personal data.',
            'is_published' => true,
            'version' => '1.0',
            'last_updated_at' => now(),
        ]);

        $this->legal_title_ar = $doc->title_ar ?? '';
        $this->legal_title_fr = $doc->title_fr ?? '';
        $this->legal_title_en = $doc->title_en ?? '';
        $this->legal_content_ar = $doc->content_ar ?? '';
        $this->legal_content_fr = $doc->content_fr ?? '';
        $this->legal_content_en = $doc->content_en ?? '';
        $this->legal_is_published = (bool) $doc->is_published;
        $this->legal_version = $doc->version ?? '1.0';
    }

    public function saveLegalDocument(): void
    {
        $doc = LegalContent::where('key', $this->legalActiveKey)->first();
        if ($doc) {
            $doc->update([
                'title_ar' => trim($this->legal_title_ar),
                'title_fr' => trim($this->legal_title_fr),
                'title_en' => trim($this->legal_title_en),
                'content_ar' => trim($this->legal_content_ar),
                'content_fr' => trim($this->legal_content_fr),
                'content_en' => trim($this->legal_content_en),
                'is_published' => $this->legal_is_published,
                'version' => trim($this->legal_version),
                'last_updated_at' => now(),
            ]);

            $this->flashMessage = 'تمت تحديثات وتوثيق الوثيقة القانونية بنجاح!';
            $this->flashMessageType = 'success';
        }
    }

    // --- APPEARANCE METHODS ---
    public function loadAppearanceSettings(): void
    {
        $settings = app(SettingsEngine::class);
        $this->site_name        = $settings->get('site_name', 'WorldSkills Algeria 2026');
        $this->primary_color    = $settings->get('primary_color', '#06205C');
        $this->accent_color     = $settings->get('accent_color', '#D97706');
        $this->site_logo_url    = $settings->get('site_logo_url', '/images/logo-ws.svg');
        $this->coming_soon_mode = (bool) $settings->get('coming_soon_mode', false);
        $this->coming_soon_title = $settings->get('coming_soon_title', 'قريباً: الانطلاقة الرسمية للأولمبياد');
    }

    public function saveAppearanceSettings(): void
    {
        $settings = app(SettingsEngine::class);
        $settings->set('site_name', trim($this->site_name));
        $settings->set('primary_color', trim($this->primary_color));
        $settings->set('accent_color', trim($this->accent_color));
        $settings->set('site_logo_url', trim($this->site_logo_url));
        $settings->set('coming_soon_mode', $this->coming_soon_mode);
        $settings->set('coming_soon_title', trim($this->coming_soon_title));

        $this->flashMessage = 'تم حفظ تخصيصات مظهر المنصة والهوية البصرية بنجاح!';
        $this->flashMessageType = 'success';
    }

    // --- DELETE ITEM CONFIRMATION ---
    public function confirmDelete(int $id, string $type, string $title = ''): void
    {
        $this->deletingItemId = $id;
        $this->deletingItemType = $type;
        $this->deletingItemTitle = $title;
        $this->showDeleteModal = true;
    }

    public function executeDeleteAction(): void
    {
        if (!$this->deletingItemId) return;

        if ($this->deletingItemType === 'NEWS') {
            NewsArticle::where('id', $this->deletingItemId)->delete();
            $this->flashMessage = 'تم حذف المقال الإخباري بنجاح!';
        } elseif ($this->deletingItemType === 'VIDEO') {
            Video::where('id', $this->deletingItemId)->delete();
            $this->flashMessage = 'تم حذف الفيديو من المكتبة بنجاح!';
        } elseif ($this->deletingItemType === 'ALBUM') {
            Album::where('id', $this->deletingItemId)->delete();
            $this->flashMessage = 'تم حذف الألبوم والمعرض بنجاح!';
        } elseif ($this->deletingItemType === 'TV_ANNOUNCEMENT') {
            LiveTvAnnouncement::where('id', $this->deletingItemId)->delete();
            $this->flashMessage = 'تم حذف الإعلان العاجل بنجاح!';
        }

        $this->flashMessageType = 'warning';
        $this->showDeleteModal = false;
        $this->deletingItemId = null;
    }

    public function render()
    {
        // Overview KPIs
        $newsCount = NewsArticle::count();
        $videosCount = Video::count();
        $albumsCount = Album::count();
        $liveTvStatus = (bool) app(SettingsEngine::class)->get('live_stream_is_active', true);

        // Fetch datasets for tabs
        $articles = NewsArticle::query()
            ->when($this->newsSearch, fn($q) => $q->where('title_ar', 'like', "%{$this->newsSearch}%"))
            ->orderByDesc('published_at')
            ->paginate(10, ['*'], 'newsPage');

        $videos = Video::query()
            ->when($this->videoSearch, fn($q) => $q->where('title_ar', 'like', "%{$this->videoSearch}%"))
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'videoPage');

        $albums = Album::query()->with('mediaItems')
            ->when($this->gallerySearch, fn($q) => $q->where('title_ar', 'like', "%{$this->gallerySearch}%"))
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'albumPage');

        $tvAnnouncements = LiveTvAnnouncement::orderByDesc('id')->get();

        return view('livewire.admin.cms-unified-hub', [
            'newsCount'       => $newsCount,
            'videosCount'     => $videosCount,
            'albumsCount'     => $albumsCount,
            'liveTvStatus'    => $liveTvStatus,
            'articles'        => $articles,
            'videos'          => $videos,
            'albums'          => $albums,
            'tvAnnouncements' => $tvAnnouncements,
        ]);
    }
}
