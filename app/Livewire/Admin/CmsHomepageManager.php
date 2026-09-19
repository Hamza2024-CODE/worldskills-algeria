<?php

namespace App\Livewire\Admin;

use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class CmsHomepageManager extends Component
{
    public $hero_title_ar;
    public $hero_title_fr;
    public $hero_title_en;
    public $hero_subtitle_ar;
    public $hero_subtitle_fr;
    public $hero_subtitle_en;
    public $cta_text_ar;
    public $cta_text_fr;
    public $cta_text_en;

    public $featured_video_url;
    public $featured_video_title_ar;
    public $featured_video_title_fr;
    public $featured_video_title_en;

    // 3D Dynamic Countdown Chronometer V8.4 Settings
    public $countdown_title_ar;
    public $countdown_title_fr;
    public $countdown_title_en;
    public $countdown_subtitle_ar;
    public $countdown_subtitle_fr;
    public $countdown_subtitle_en;
    public $countdown_target_date;
    public $countdown_timezone;
    public $countdown_status;
    public $countdown_theme;
    public $countdown_digit_style;
    public $countdown_color_sec;
    public $countdown_color_min;
    public $countdown_color_hrs;
    public $countdown_color_days;
    public $countdown_show_icons = true;
    public $countdown_flip_animation = true;
    public $countdown_enabled = true;

    // Master Registration & Section Switch Controls (ON / OFF Toggles)
    public bool $registration_competitors_enabled = true;
    public bool $registration_supporters_enabled = true;
    public bool $registration_accreditation_enabled = true;
    public bool $page_partners_enabled = true;

    // Breaking News Ticker Controls (شريط الأخبار والإعلانات التفاعلي)
    public bool $news_ticker_enabled = true;
    public $news_ticker_badge_ar;
    public $news_ticker_badge_fr;
    public $news_ticker_badge_en;
    public $news_ticker_text_ar;
    public $news_ticker_text_fr;
    public $news_ticker_text_en;
    public $news_ticker_url;
    public $news_ticker_theme = 'royal_gradient';
    public $news_ticker_speed = 'normal';

    public $activeTab = 'registration_switches';
    public $savedMessage = '';

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function mount(SettingsEngine $settings)
    {
        $this->hero_title_ar = $settings->get('home_hero_title_ar', 'أولمبياد المهن الجزائرية 2026');
        $this->hero_title_fr = $settings->get('home_hero_title_fr', 'Olympiades des Métiers Algérie 2026');
        $this->hero_title_en = $settings->get('home_hero_title_en', 'WorldSkills Competition Algeria 2026');

        $this->hero_subtitle_ar = $settings->get('home_hero_subtitle_ar', 'من 16 إلى 21 نوفمبر 2026 — مركز المؤتمرات وهران');
        $this->hero_subtitle_fr = $settings->get('home_hero_subtitle_fr', 'Du 16 au 21 Novembre 2026 — Oran');
        $this->hero_subtitle_en = $settings->get('home_hero_subtitle_en', '16 to 21 November 2026 — Oran');

        $this->cta_text_ar = $settings->get('home_cta_text_ar', 'كن جزءاً من أكبر حدث للمهارات في الجزائر!');
        $this->cta_text_fr = $settings->get('home_cta_text_fr', 'Faites partie du plus grand événement des compétences en Algérie!');
        $this->cta_text_en = $settings->get('home_cta_text_en', 'Be part of the largest skills event in Algeria!');

        $this->featured_video_url = $settings->get('featured_video_url', 'https://www.youtube.com/embed/nzy4f7GBSVw');
        $this->featured_video_title_ar = $settings->get('featured_video_title_ar', 'أجواء أولمبياد المهن بالجزائر — وهران 2026');
        $this->featured_video_title_fr = $settings->get('featured_video_title_fr', 'Ambiance des Olympiades des Métiers — Oran 2026');
        $this->featured_video_title_en = $settings->get('featured_video_title_en', 'WorldSkills Competition Highlights — Oran 2026');

        // Dynamic 3D Countdown Chronometer Settings
        $this->countdown_title_ar      = $settings->get('countdown_title_ar', 'العد التنازلي لافتتاح أولمبياد المهن 2026');
        $this->countdown_title_fr      = $settings->get('countdown_title_fr', 'Décompte du Lancement des Olympiades des Métiers 2026');
        $this->countdown_title_en      = $settings->get('countdown_title_en', 'Countdown to the Opening of WorldSkills Algeria 2026');

        $this->countdown_subtitle_ar   = $settings->get('countdown_subtitle_ar', 'أولمبياد المهن 2026 — مركز المؤتمرات محمد بن أحمد - وهران');
        $this->countdown_subtitle_fr   = $settings->get('countdown_subtitle_fr', 'WorldSkills Algeria 2026 — Oran');
        $this->countdown_subtitle_en   = $settings->get('countdown_subtitle_en', 'WorldSkills Algeria 2026 — Oran');

        $this->countdown_target_date   = $settings->get('countdown_target_date', '2026-11-16 09:00:00');
        $this->countdown_timezone      = $settings->get('countdown_timezone', 'Africa/Algiers');
        $this->countdown_status        = $settings->get('countdown_status', 'COUNTDOWN');
        $this->countdown_theme         = $settings->get('countdown_theme', 'vintage_spiral_notebook');
        $this->countdown_digit_style   = $settings->get('countdown_digit_style', 'classic_mono');

        $this->countdown_color_sec     = $settings->get('countdown_color_sec', '#0284C7');
        $this->countdown_color_min     = $settings->get('countdown_color_min', '#059669');
        $this->countdown_color_hrs     = $settings->get('countdown_color_hrs', '#D97706');
        $this->countdown_color_days    = $settings->get('countdown_color_days', '#7C3AED');

        $this->countdown_show_icons    = (bool) $settings->get('countdown_show_icons', true);
        $this->countdown_flip_animation = (bool) $settings->get('countdown_flip_animation', true);
        $this->countdown_enabled       = (bool) $settings->get('countdown_enabled', true);

        // Load Master Registration & Page Switches
        $this->registration_competitors_enabled = $settings->getBool('registration_competitors_enabled', true);
        $this->registration_supporters_enabled  = $settings->getBool('registration_supporters_enabled', true);
        $this->registration_accreditation_enabled = $settings->getBool('registration_accreditation_enabled', true);
        $this->page_partners_enabled              = $settings->getBool('page_partners_enabled', true);

        // Load News Ticker Settings
        $this->news_ticker_enabled   = (bool) $settings->get('news_ticker_enabled', true);
        $this->news_ticker_badge_ar  = $settings->get('news_ticker_badge_ar', 'إعلان رسمي | منتدى 2026');
        $this->news_ticker_badge_fr  = $settings->get('news_ticker_badge_fr', 'Annonce Officielle | Forum 2026');
        $this->news_ticker_badge_en  = $settings->get('news_ticker_badge_en', 'Official Announcement | Forum 2026');

        $this->news_ticker_text_ar   = $settings->get('news_ticker_text_ar', 'انعقاد منتدى السياسات الإفريقية للمهارات 2026 بالتزامن مع أولمبياد المهن الجزائرية — مركز المؤتمرات محمد بن أحمد وهران');
        $this->news_ticker_text_fr   = $settings->get('news_ticker_text_fr', 'Tenue du Forum sur les Politiques Africaines des Compétences 2026 en marge des Olympiades des Métiers — Centre des Conventions Oran');
        $this->news_ticker_text_en   = $settings->get('news_ticker_text_en', 'The African Skills Policy Forum 2026 to be held concurrently with WorldSkills Algeria 2026 — Oran Convention Center');

        $this->news_ticker_url       = $settings->get('news_ticker_url', 'https://africaskills-policyforum.worldskills.dz/');
        $this->news_ticker_theme     = $settings->get('news_ticker_theme', 'royal_gradient');
        $this->news_ticker_speed     = $settings->get('news_ticker_speed', 'normal');
    }

    public function toggleNewsTicker(SettingsEngine $settings)
    {
        $this->news_ticker_enabled = !$this->news_ticker_enabled;
        $settings->set('news_ticker_enabled', $this->news_ticker_enabled);
        $status = $this->news_ticker_enabled ? 'مفعل ويظهر في الصفحة الرئيسية' : 'معطل ومخفي';
        $this->savedMessage = "تم تعديل حالة شريط الأخبار إلى: {$status}";
    }

    public function toggleRegistration(string $type, ?SettingsEngine $settings = null)
    {
        $settings = $settings ?? app(SettingsEngine::class);

        if ($type === 'competitors') {
            $this->registration_competitors_enabled = !$this->registration_competitors_enabled;
            $settings->set('registration_competitors_enabled', $this->registration_competitors_enabled);
            $status = $this->registration_competitors_enabled ? 'مفتوح' : 'مغلق';
            $this->savedMessage = "تم تعديل حالة تسجيل المتنافسين الشباب إلى: {$status}";
        } elseif ($type === 'supporters') {
            $this->registration_supporters_enabled = !$this->registration_supporters_enabled;
            $settings->set('registration_supporters_enabled', $this->registration_supporters_enabled);
            $status = $this->registration_supporters_enabled ? 'مفتوح' : 'مغلق';
            $this->savedMessage = "تم تعديل حالة تسجيل التشجيع الرسمي إلى: {$status}";
        } elseif ($type === 'accreditation') {
            $this->registration_accreditation_enabled = !$this->registration_accreditation_enabled;
            $settings->set('registration_accreditation_enabled', $this->registration_accreditation_enabled);
            $status = $this->registration_accreditation_enabled ? 'مفتوح' : 'مغلق';
            $this->savedMessage = "تم تعديل حالة تسجيل الاعتمادات والشارات إلى: {$status}";
        } elseif ($type === 'partners') {
            $this->page_partners_enabled = !$this->page_partners_enabled;
            $settings->set('page_partners_enabled', $this->page_partners_enabled);
            $status = $this->page_partners_enabled ? 'مفعلة ومتاحة' : 'معطلة ومخفية';
            $this->savedMessage = "تم تعديل حالة صفحة وقسم الشركاء والرعاة إلى: {$status}";
        }
    }

    public function saveSettings(SettingsEngine $settings)
    {
        $settings->set('home_hero_title_ar', $this->hero_title_ar);
        $settings->set('home_hero_title_fr', $this->hero_title_fr);
        $settings->set('home_hero_title_en', $this->hero_title_en);

        $settings->set('home_hero_subtitle_ar', $this->hero_subtitle_ar);
        $settings->set('home_hero_subtitle_fr', $this->hero_subtitle_fr);
        $settings->set('home_hero_subtitle_en', $this->hero_subtitle_en);

        $settings->set('home_cta_text_ar', $this->cta_text_ar);
        $settings->set('home_cta_text_fr', $this->cta_text_fr);
        $settings->set('home_cta_text_en', $this->cta_text_en);

        $settings->set('featured_video_url', $this->featured_video_url);
        $settings->set('featured_video_title_ar', $this->featured_video_title_ar);
        $settings->set('featured_video_title_fr', $this->featured_video_title_fr);
        $settings->set('featured_video_title_en', $this->featured_video_title_en);

        // Save Countdown Settings
        $settings->set('countdown_title_ar', $this->countdown_title_ar);
        $settings->set('countdown_title_fr', $this->countdown_title_fr);
        $settings->set('countdown_title_en', $this->countdown_title_en);
        $settings->set('countdown_subtitle_ar', $this->countdown_subtitle_ar);
        $settings->set('countdown_subtitle_fr', $this->countdown_subtitle_fr);
        $settings->set('countdown_subtitle_en', $this->countdown_subtitle_en);
        $settings->set('countdown_target_date', $this->countdown_target_date);
        $settings->set('countdown_timezone', $this->countdown_timezone);
        $settings->set('countdown_status', $this->countdown_status);
        $settings->set('countdown_theme', $this->countdown_theme);
        $settings->set('countdown_digit_style', $this->countdown_digit_style);
        $settings->set('countdown_color_sec', $this->countdown_color_sec);
        $settings->set('countdown_color_min', $this->countdown_color_min);
        $settings->set('countdown_color_hrs', $this->countdown_color_hrs);
        $settings->set('countdown_color_days', $this->countdown_color_days);
        $settings->set('countdown_show_icons', $this->countdown_show_icons);
        $settings->set('countdown_flip_animation', $this->countdown_flip_animation);
        $settings->set('countdown_enabled', $this->countdown_enabled);

        // Save Master Switches
        $settings->set('registration_competitors_enabled', $this->registration_competitors_enabled);
        $settings->set('registration_supporters_enabled', $this->registration_supporters_enabled);
        $settings->set('registration_accreditation_enabled', $this->registration_accreditation_enabled);
        $settings->set('page_partners_enabled', $this->page_partners_enabled);

        // Save News Ticker Settings
        $settings->set('news_ticker_enabled', $this->news_ticker_enabled);
        $settings->set('news_ticker_badge_ar', $this->news_ticker_badge_ar);
        $settings->set('news_ticker_badge_fr', $this->news_ticker_badge_fr);
        $settings->set('news_ticker_badge_en', $this->news_ticker_badge_en);
        $settings->set('news_ticker_text_ar', $this->news_ticker_text_ar);
        $settings->set('news_ticker_text_fr', $this->news_ticker_text_fr);
        $settings->set('news_ticker_text_en', $this->news_ticker_text_en);
        $settings->set('news_ticker_url', $this->news_ticker_url);
        $settings->set('news_ticker_theme', $this->news_ticker_theme);
        $settings->set('news_ticker_speed', $this->news_ticker_speed);

        $this->savedMessage = 'تم حفظ كافة إعدادات المنصة ومفاتيح فتح/غلق التسجيل والصفحات بنجاح وتطبيقها مباشرة.';
    }

    public function resetSettings(SettingsEngine $settings)
    {
        $this->registration_competitors_enabled = true;
        $this->registration_supporters_enabled  = true;
        $this->registration_accreditation_enabled = true;
        $this->page_partners_enabled              = true;
        $this->saveSettings($settings);
        $this->savedMessage = 'تمت إعادة ضبط إعدادات التفعيل إلى الوضع الافتراضي (جميع الأقسام والتسجيلات مفتوحة).';
    }

    public function render()
    {
        return view('livewire.admin.cms-homepage-manager');
    }
}
