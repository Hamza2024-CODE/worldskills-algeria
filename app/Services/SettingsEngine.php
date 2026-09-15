<?php

namespace App\Services;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Cache;

class SettingsEngine
{
    protected const CACHE_KEY = 'wsap_global_settings';
    protected const CACHE_TTL = 86400; // 24 hours

    public const DEFAULTS = [
        'appearance.primary_color' => '#0066FF',
        'appearance.primary_dark' => '#063B8F',
        'appearance.accent_color' => '#00B8FF',
        'appearance.background_color' => '#F4F7FC',
        'appearance.surface_color' => '#FFFFFF',
        'appearance.text_color' => '#0F172A',
        'appearance.muted_text_color' => '#64748B',

        'appearance.success_color' => '#16A34A',
        'appearance.warning_color' => '#F59E0B',
        'appearance.danger_color' => '#DC2626',
        'appearance.info_color' => '#0EA5E9',

        'appearance.radius_sm' => '0.375rem',
        'appearance.radius_md' => '0.75rem',
        'appearance.radius_lg' => '1rem',
        'appearance.radius_xl' => '1.5rem',

        'appearance.glassmorphism_enabled' => 'true',
        'appearance.animation_level' => 'full',

        'branding.site_name' => 'WorldSkills Algeria',
        'branding.site_logo' => '/logo.svg',
        'branding.site_logo_dark' => '/logo.svg',
        'branding.favicon' => '/favicon.ico',
        'branding.hero_banner' => '/banner.png',
        'branding.footer_logo' => '/logo.svg',
    ];

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return GlobalSetting::all()->pluck('value', 'key')->toArray();
        });

        if (!array_key_exists($key, $settings)) {
            return $default ?? (self::DEFAULTS[$key] ?? null);
        }

        return $settings[$key];
    }

    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general', ?string $description = null): void
    {
        $oldValue = $this->get($key);

        GlobalSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_bool($value) ? ($value ? '1' : '0') : (is_array($value) ? json_encode($value) : (string) $value),
                'type' => is_bool($value) ? 'boolean' : $type,
                'group' => $group,
                'description' => $description,
            ]
        );

        $this->flushCache();

        if (class_exists(AuditService::class)) {
            AuditService::log('SETTING_UPDATED', null, [
                'key' => $key,
                'group' => $group,
                'old_value' => $oldValue,
                'new_value' => $value,
            ]);
        }
    }

    public function getBool(string $key, bool $default = false): bool
    {
        $val = $this->get($key, null);
        if ($val === null) {
            return $default;
        }
        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    public function getInt(string $key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }

    public function resetToDefaults(): void
    {
        foreach (self::DEFAULTS as $key => $defaultValue) {
            GlobalSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $defaultValue, 'group' => 'appearance']
            );
        }

        $this->flushCache();

        if (class_exists(AuditService::class)) {
            AuditService::log('APPEARANCE_RESET', null, [
                'action' => 'appearance.reset',
                'module' => 'appearance',
                'message' => 'Appearance tokens restored to factory defaults.',
            ]);
        }
    }

    /**
     * Generate safe, sanitized CSS Custom Properties (:root) for Design Tokens
     */
    public function getDesignTokensCss(): string
    {
        $primary = $this->sanitizeHex($this->get('appearance.primary_color', '#0066FF'));
        $primaryDark = $this->sanitizeHex($this->get('appearance.primary_dark', '#063B8F'));
        $accent = $this->sanitizeHex($this->get('appearance.accent_color', '#00B8FF'));
        $bg = $this->sanitizeHex($this->get('appearance.background_color', '#F4F7FC'));
        $surface = $this->sanitizeHex($this->get('appearance.surface_color', '#FFFFFF'));
        $text = $this->sanitizeHex($this->get('appearance.text_color', '#0F172A'));
        $mutedText = $this->sanitizeHex($this->get('appearance.muted_text_color', '#64748B'));

        $success = $this->sanitizeHex($this->get('appearance.success_color', '#16A34A'));
        $warning = $this->sanitizeHex($this->get('appearance.warning_color', '#F59E0B'));
        $danger = $this->sanitizeHex($this->get('appearance.danger_color', '#DC2626'));
        $info = $this->sanitizeHex($this->get('appearance.info_color', '#0EA5E9'));

        $radiusSm = $this->sanitizeRadius($this->get('appearance.radius_sm', '0.375rem'));
        $radiusMd = $this->sanitizeRadius($this->get('appearance.radius_md', '0.75rem'));
        $radiusLg = $this->sanitizeRadius($this->get('appearance.radius_lg', '1rem'));
        $radiusXl = $this->sanitizeRadius($this->get('appearance.radius_xl', '1.5rem'));

        return "<style id=\"wsap-design-tokens\">
:root {
    --color-brand-primary: {$primary};
    --color-brand-primary-dark: {$primaryDark};
    --color-brand-accent: {$accent};

    --color-background: {$bg};
    --color-surface: {$surface};
    --color-text: {$text};
    --color-muted-text: {$mutedText};

    --color-success: {$success};
    --color-warning: {$warning};
    --color-danger: {$danger};
    --color-info: {$info};

    --radius-sm: {$radiusSm};
    --radius-md: {$radiusMd};
    --radius-lg: {$radiusLg};
    --radius-xl: {$radiusXl};
}
</style>";
    }

    private function sanitizeHex(mixed $val): string
    {
        $val = trim((string) $val);
        if (preg_match('/^#[0-9A-Fa-f]{3,8}$/', $val)) {
            return $val;
        }
        return '#0066FF';
    }

    private function sanitizeRadius(mixed $val): string
    {
        $allowed = ['0', '0.25rem', '0.375rem', '0.5rem', '0.75rem', '1rem', '1.5rem', '2rem', '9999px'];
        $val = trim((string) $val);
        if (in_array($val, $allowed, true)) {
            return $val;
        }
        return '1rem';
    }

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
