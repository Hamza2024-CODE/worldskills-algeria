<?php

namespace App\Livewire\Public;

use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class ComingSoon extends Component
{
    public string $title = '';
    public string $message = '';
    public string $launchDate = '';
    public bool $isComingSoonActive = false;

    public function mount(SettingsEngine $settings): void
    {
        $this->isComingSoonActive = $settings->getBool('coming_soon_mode', false);
        $this->title = $settings->get('coming_soon_title', 'انتظرونا قريباً — الإطلاق الرسمي لأولمبياد المهن');
        $this->message = $settings->get('coming_soon_message', 'المنصة الوطنية لأولمبياد المهن والمهارات الجزائرية في مرحلة اللمسات الأخيرة والتجهيز النهائي لتوفير تجربة استثنائية.');
        $this->launchDate = $settings->get('coming_soon_launch_date', '2026-11-01T09:00:00');
    }

    public function render()
    {
        return view('livewire.public.coming-soon');
    }
}
