<?php

namespace App\Livewire\Public;

use App\Models\Partner;
use App\Services\HomepageStatisticsService;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Partners extends Component
{
    public bool $pagePartnersEnabled = true;

    public function mount(SettingsEngine $settings)
    {
        $this->pagePartnersEnabled = (bool) $settings->get('page_partners_enabled', true);
    }

    public function render(HomepageStatisticsService $statsService)
    {
        $featuredPartners = Partner::where('status', 'ACTIVE')
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->orderBy('name_ar')
            ->get();

        $allPartners = Partner::where('status', 'ACTIVE')
            ->orderBy('sort_order')
            ->orderBy('name_ar')
            ->get();

        return view('livewire.public.partners', [
            'featuredPartners'    => $featuredPartners,
            'allPartners'         => $allPartners,
            'pagePartnersEnabled' => $this->pagePartnersEnabled,
            'stats'               => $statsService->getStatistics(),
        ]);
    }
}
