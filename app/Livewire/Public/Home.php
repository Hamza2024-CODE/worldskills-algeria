<?php

namespace App\Livewire\Public;

use App\Models\Album;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Skill;
use App\Models\Video;
use App\Services\DateEngine;
use App\Services\HomepageStatisticsService;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Home extends Component
{
    public $activeEvent;
    public $eventCountdown = [];
    public $featuredVideoUrl;
    public $stats = [];

    // Dynamic 3D Countdown Controls V8.4 from Admin Settings
    public string $countdownTitleAr;
    public string $countdownTitleFr;
    public string $countdownTitleEn;
    public string $countdownSubtitleAr;
    public string $countdownSubtitleFr;
    public string $countdownSubtitleEn;
    public string $countdownTargetDate;
    public string $countdownTimezone;
    public string $countdownStatus;
    public string $countdownTheme;
    public string $countdownDigitStyle;
    public string $countdownColorSec;
    public string $countdownColorMin;
    public string $countdownColorHrs;
    public string $countdownColorDays;
    public bool   $countdownShowIcons;
    public bool   $countdownFlipAnimation;
    public bool   $countdownEnabled;

    public function mount(
        DateEngine $dateEngine, 
        SettingsEngine $settings, 
        HomepageStatisticsService $statsService
    ) {
        $this->activeEvent = Event::where('is_active', true)->where('status', 'PUBLISHED')->first() 
            ?? Event::where('status', 'PUBLISHED')->orderBy('start_at')->first();

        $this->featuredVideoUrl = $settings->get('featured_video_url', 'https://www.youtube.com/embed/nzy4f7GBSVw');

        // Retrieve Admin Settings for Countdown Chronometer V8.4
        $this->countdownTitleAr     = $settings->get('countdown_title_ar', 'العد التنازلي لافتتاح أولمبياد المهن 2026');
        $this->countdownTitleFr     = $settings->get('countdown_title_fr', 'Décompte du Lancement des Olympiades des Métiers 2026');
        $this->countdownTitleEn     = $settings->get('countdown_title_en', 'Countdown to the Opening of the 2026 Olympiad of Professions');

        $this->countdownSubtitleAr  = $settings->get('countdown_subtitle_ar', 'أولمبياد المهن 2026 — مركز المؤتمرات محمد بن أحمد - وهران');
        $this->countdownSubtitleFr  = $settings->get('countdown_subtitle_fr', 'Olympiades des Métiers 2026 — Centre des Conventions Mohamed Benahmed - Oran');
        $this->countdownSubtitleEn  = $settings->get('countdown_subtitle_en', 'Olympiad of Professions 2026 — Mohamed Benahmed Convention Center - Oran');

        $this->countdownTargetDate  = $settings->get('countdown_target_date', '2026-09-15 09:00:00');
        $this->countdownTimezone     = $settings->get('countdown_timezone', 'Africa/Algiers');
        $this->countdownStatus       = $settings->get('countdown_status', 'COUNTDOWN');
        $this->countdownTheme        = $settings->get('countdown_theme', 'vintage_spiral_notebook');
        $this->countdownDigitStyle  = $settings->get('countdown_digit_style', 'classic_mono');

        $this->countdownColorSec    = $settings->get('countdown_color_sec', '#0284C7');
        $this->countdownColorMin    = $settings->get('countdown_color_min', '#059669');
        $this->countdownColorHrs    = $settings->get('countdown_color_hrs', '#D97706');
        $this->countdownColorDays   = $settings->get('countdown_color_days', '#7C3AED');

        $this->countdownShowIcons   = (bool) $settings->get('countdown_show_icons', true);
        $this->countdownFlipAnimation = (bool) $settings->get('countdown_flip_animation', true);
        $this->countdownEnabled      = (bool) $settings->get('countdown_enabled', true);

        // Calculate initial fallback difference
        $targetCarbon = \Carbon\Carbon::parse($this->countdownTargetDate);
        $diff = now()->diff($targetCarbon);

        $this->eventCountdown = [
            'days'     => str_pad($diff->days, 2, '0', STR_PAD_LEFT),
            'hours'    => str_pad($diff->h, 2, '0', STR_PAD_LEFT),
            'minutes'  => str_pad($diff->i, 2, '0', STR_PAD_LEFT),
            'seconds'  => str_pad($diff->s, 2, '0', STR_PAD_LEFT),
            'target_timestamp' => $targetCarbon->timestamp * 1000,
        ];

        $this->stats = $statsService->getStatistics();
    }

    public function render()
    {
        $skills = Skill::where('is_active', true)
            ->whereIn('code', ['SKILL-16', 'SKILL-14', 'SKILL-13', 'SKILL-15', 'SKILL-39', 'SKILL-54'])
            ->get();

        if ($skills->count() < 6) {
            $skills = Skill::where('is_active', true)->limit(6)->get();
        }

        $news = NewsArticle::where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
        if ($news->isEmpty()) {
            $news = NewsArticle::orderBy('created_at', 'desc')->limit(3)->get();
        }

        $albums = Album::with(['coverMedia', 'mediaItems'])->where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
        if ($albums->isEmpty()) {
            $albums = Album::with(['coverMedia', 'mediaItems'])->orderBy('created_at', 'desc')->limit(3)->get();
        }

        $videos = Video::where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
        if ($videos->isEmpty()) {
            $videos = Video::orderBy('created_at', 'desc')->limit(3)->get();
        }

        $partners = Partner::where('status', 'ACTIVE')->where('is_featured', true)->orderBy('sort_order')->orderBy('name_ar')->get();

        return view('livewire.public.home', array_merge(get_object_vars($this), [
            'skills'   => $skills,
            'news'     => $news,
            'albums'   => $albums,
            'videos'   => $videos,
            'partners' => $partners,
        ]));
    }
}
