<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\AuditService;
use App\Services\SettingsEngine;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class PlatformAppearanceManager extends Component
{
    use WithFileUploads;

    public string $primary_color;
    public string $primary_dark;
    public string $accent_color;

    public string $background_color;
    public string $surface_color;
    public string $text_color;
    public string $muted_text_color;

    public string $success_color;
    public string $warning_color;
    public string $danger_color;
    public string $info_color;

    public string $radius_sm;
    public string $radius_md;
    public string $radius_lg;
    public string $radius_xl;

    public string $site_name;
    public string $site_logo_url;
    public string $favicon_url;
    public string $hero_banner_url;

    // Coming Soon Settings
    public bool $coming_soon_mode = false;
    public string $coming_soon_title = '';
    public string $coming_soon_message = '';
    public string $coming_soon_launch_date = '';

    public string $previewDevice = 'desktop';

    public mixed $site_logo_file = null;
    public mixed $favicon_file = null;
    public mixed $hero_banner_file = null;

    public string $savedMessage = '';
    public string $errorMessage = '';

    public function mount(SettingsEngine $settings)
    {
        $user = Auth::user();
        if (!Auth::check() || !$user instanceof User || !$user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            throw new AuthorizationException('Access denied to Platform Appearance Studio.');
        }

        $this->loadSettings($settings);
    }

    public function loadSettings(SettingsEngine $settings): void
    {
        $this->primary_color = $settings->get('appearance.primary_color', '#0066FF');
        $this->primary_dark = $settings->get('appearance.primary_dark', '#063B8F');
        $this->accent_color = $settings->get('appearance.accent_color', '#00B8FF');

        $this->background_color = $settings->get('appearance.background_color', '#F4F7FC');
        $this->surface_color = $settings->get('appearance.surface_color', '#FFFFFF');
        $this->text_color = $settings->get('appearance.text_color', '#0F172A');
        $this->muted_text_color = $settings->get('appearance.muted_text_color', '#64748B');

        $this->success_color = $settings->get('appearance.success_color', '#16A34A');
        $this->warning_color = $settings->get('appearance.warning_color', '#F59E0B');
        $this->danger_color = $settings->get('appearance.danger_color', '#DC2626');
        $this->info_color = $settings->get('appearance.info_color', '#0EA5E9');

        $this->radius_sm = $settings->get('appearance.radius_sm', '0.375rem');
        $this->radius_md = $settings->get('appearance.radius_md', '0.75rem');
        $this->radius_lg = $settings->get('appearance.radius_lg', '1rem');
        $this->radius_xl = $settings->get('appearance.radius_xl', '1.5rem');

        $this->site_name = $settings->get('branding.site_name', 'WorldSkills Algeria');
        $this->site_logo_url = $settings->get('branding.site_logo', '/logo.svg');
        $this->favicon_url = $settings->get('branding.favicon', '/favicon.ico');
        $this->hero_banner_url = $settings->get('branding.hero_banner', '/banner.png');

        $this->coming_soon_mode = $settings->getBool('coming_soon_mode', false);
        $this->coming_soon_title = $settings->get('coming_soon_title', 'انتظرونا قريباً — الإطلاق الرسمي لأولمبياد المهن');
        $this->coming_soon_message = $settings->get('coming_soon_message', 'المنصة الوطنية لأولمبياد المهن والمهارات الجزائرية في مرحلة اللمسات الأخيرة والتجهيز النهائي لتوفير تجربة استثنائية.');
        $this->coming_soon_launch_date = $settings->get('coming_soon_launch_date', '2026-11-01T09:00:00');
    }

    public function saveAppearance(SettingsEngine $settings)
    {
        $user = Auth::user();
        if (!Auth::check() || !$user instanceof User || !$user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            throw new AuthorizationException('Access denied.');
        }

        $this->validate([
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'primary_dark' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'accent_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'background_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'surface_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'text_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'muted_text_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'success_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'warning_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'danger_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'info_color' => ['required', 'regex:/^#[0-9A-Fa-f]{3,8}$/'],
            'radius_sm' => ['required', 'in:0,0.25rem,0.375rem,0.5rem'],
            'radius_md' => ['required', 'in:0.5rem,0.75rem,1rem'],
            'radius_lg' => ['required', 'in:0.75rem,1rem,1.5rem'],
            'radius_xl' => ['required', 'in:1rem,1.5rem,2rem,9999px'],
            'site_name' => ['required', 'string', 'max:100'],
            'site_logo_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'favicon_file' => ['nullable', 'file', 'mimes:ico,png,svg', 'max:1024'],
            'hero_banner_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'coming_soon_title' => ['nullable', 'string', 'max:255'],
            'coming_soon_message' => ['nullable', 'string', 'max:1000'],
            'coming_soon_launch_date' => ['nullable', 'string'],
        ]);

        // Process File Uploads Safely
        if ($this->site_logo_file) {
            $path = $this->site_logo_file->store('branding', 'public');
            $this->site_logo_url = '/storage/' . $path;
            $settings->set('branding.site_logo', $this->site_logo_url, 'string', 'branding');
            $settings->set('site_logo', $this->site_logo_url, 'string', 'branding');
        } elseif ($this->site_logo_url) {
            $settings->set('branding.site_logo', $this->site_logo_url, 'string', 'branding');
            $settings->set('site_logo', $this->site_logo_url, 'string', 'branding');
        }

        if ($this->favicon_file) {
            $path = $this->favicon_file->store('branding', 'public');
            $this->favicon_url = '/storage/' . $path;
            $settings->set('branding.favicon', $this->favicon_url, 'string', 'branding');
        }

        if ($this->hero_banner_file) {
            $path = $this->hero_banner_file->store('branding', 'public');
            $this->hero_banner_url = '/storage/' . $path;
            $settings->set('branding.hero_banner', $this->hero_banner_url, 'string', 'branding');
        }

        // Save Color & Radius Design Tokens
        $settings->set('appearance.primary_color', $this->primary_color, 'string', 'appearance');
        $settings->set('appearance.primary_dark', $this->primary_dark, 'string', 'appearance');
        $settings->set('appearance.accent_color', $this->accent_color, 'string', 'appearance');
        $settings->set('appearance.background_color', $this->background_color, 'string', 'appearance');
        $settings->set('appearance.surface_color', $this->surface_color, 'string', 'appearance');
        $settings->set('appearance.text_color', $this->text_color, 'string', 'appearance');
        $settings->set('appearance.muted_text_color', $this->muted_text_color, 'string', 'appearance');

        $settings->set('appearance.success_color', $this->success_color, 'string', 'appearance');
        $settings->set('appearance.warning_color', $this->warning_color, 'string', 'appearance');
        $settings->set('appearance.danger_color', $this->danger_color, 'string', 'appearance');
        $settings->set('appearance.info_color', $this->info_color, 'string', 'appearance');

        $settings->set('appearance.radius_sm', $this->radius_sm, 'string', 'appearance');
        $settings->set('appearance.radius_md', $this->radius_md, 'string', 'appearance');
        $settings->set('appearance.radius_lg', $this->radius_lg, 'string', 'appearance');
        $settings->set('appearance.radius_xl', $this->radius_xl, 'string', 'appearance');

        $settings->set('branding.site_name', $this->site_name, 'string', 'branding');

        // Save Coming Soon Settings
        $settings->set('coming_soon_mode', $this->coming_soon_mode ? '1' : '0', 'boolean', 'general');
        $settings->set('coming_soon_title', $this->coming_soon_title, 'string', 'general');
        $settings->set('coming_soon_message', $this->coming_soon_message, 'string', 'general');
        $settings->set('coming_soon_launch_date', $this->coming_soon_launch_date, 'string', 'general');

        $settings->flushCache();

        AuditService::log('PLATFORM_APPEARANCE_UPDATED', null, [
            'module' => 'appearance',
            'primary_color' => $this->primary_color,
            'primary_dark' => $this->primary_dark,
            'accent_color' => $this->accent_color,
            'site_name' => $this->site_name,
        ]);

        $this->savedMessage = __('تم حفظ هوية ومظهر المنصة بنجاح وتحديث كافة الصفحات واللوحات فوراً.');
    }

    public function resetDefaults(SettingsEngine $settings)
    {
        $user = Auth::user();
        if (!Auth::check() || !$user instanceof User || !$user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            throw new AuthorizationException('Access denied.');
        }

        $settings->resetToDefaults();
        $this->loadSettings($settings);

        $this->savedMessage = __('تمت إعادة كافة رموز التصميم والهوية البصرية إلى افتراضيات المصنع.');
    }

    public function setPreviewDevice(string $device): void
    {
        if (in_array($device, ['desktop', 'tablet', 'mobile'], true)) {
            $this->previewDevice = $device;
        }
    }

    public function render()
    {
        return view('livewire.admin.platform-appearance-manager');
    }
}
