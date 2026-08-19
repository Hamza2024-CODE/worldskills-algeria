<?php

namespace App\Livewire\Admin;

use App\Models\LiveTvAnnouncement;
use App\Models\LiveTvSlide;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class LiveTvIndex extends Component
{
    use WithFileUploads;

    // Stream settings
    public string $liveStreamUrl = '';
    public string $liveStreamTitle = '';
    public bool $liveStreamIsActive = true;

    // Ticker Announcements Form
    public string $tickerTextAr = '';
    public string $tickerTextFr = '';
    public ?int $editingAnnouncementId = null;
    public bool $showAnnouncementModal = false;

    // Slides Form
    public string $slideTitleAr = '';
    public string $slideTitleFr = '';
    public string $slideType = 'image'; // image, announcement, video_promo
    public string $slideContent = '';
    public string $slideImageUrl = '';
    public int $slideDurationSec = 10;
    public int $slideSortOrder = 1;
    public ?int $editingSlideId = null;
    public bool $showSlideModal = false;

    public function mount()
    {
        $settings = app(SettingsEngine::class);
        $this->liveStreamUrl      = $settings->get('live_stream_url', '');
        $this->liveStreamTitle    = $settings->get('live_stream_title', 'البث المباشر الرسمي للأولمبياد الوطنية 2026');
        $this->liveStreamIsActive = (bool) $settings->get('live_stream_is_active', true);
    }

    public function saveStreamSettings()
    {
        $settings = app(SettingsEngine::class);
        $settings->set('live_stream_url', trim($this->liveStreamUrl));
        $settings->set('live_stream_title', trim($this->liveStreamTitle));
        $settings->set('live_stream_is_active', $this->liveStreamIsActive);

        session()->flash('message', app()->getLocale() === 'fr' 
            ? 'Paramètres du flux en direct mis à jour.' 
            : (app()->getLocale() === 'en' 
                ? 'Live stream settings updated successfully.' 
                : 'تم تحديث إعدادات البث المباشر بنجاح.'));
    }

    // --- ANNOUNCEMENTS MANAGEMENT ---
    public function openAnnouncementModal(?int $id = null)
    {
        $this->resetErrorBag();
        $this->editingAnnouncementId = $id;

        if ($id) {
            $ann = LiveTvAnnouncement::find($id);
            if ($ann) {
                $this->tickerTextAr = $ann->ticker_text_ar ?? '';
                $this->tickerTextFr = $ann->ticker_text_fr ?? '';
            }
        } else {
            $this->tickerTextAr = '';
            $this->tickerTextFr = '';
        }

        $this->showAnnouncementModal = true;
    }

    public function saveAnnouncement()
    {
        $this->validate([
            'tickerTextAr' => 'required|string|max:500',
        ], [
            'tickerTextAr.required' => 'يرجى إدخال نص الخبر المتحرك.',
        ]);

        if ($this->editingAnnouncementId) {
            $ann = LiveTvAnnouncement::find($this->editingAnnouncementId);
            if ($ann) {
                $ann->update([
                    'ticker_text_ar' => trim($this->tickerTextAr),
                    'ticker_text_fr' => trim($this->tickerTextFr),
                ]);
            }
        } else {
            LiveTvAnnouncement::create([
                'ticker_text_ar' => trim($this->tickerTextAr),
                'ticker_text_fr' => trim($this->tickerTextFr),
                'is_active'      => true,
            ]);
        }

        $this->showAnnouncementModal = false;
        session()->flash('message', 'تم حفظ الخبر المتحرك بنجاح.');
    }

    public function toggleAnnouncementStatus(int $id)
    {
        $ann = LiveTvAnnouncement::find($id);
        if ($ann) {
            $ann->update(['is_active' => !$ann->is_active]);
        }
    }

    public function deleteAnnouncement(int $id)
    {
        $ann = LiveTvAnnouncement::find($id);
        if ($ann) {
            $ann->delete();
            session()->flash('message', 'تم حذف الخبر المتحرك.');
        }
    }

    // --- SLIDES MANAGEMENT ---
    public function openSlideModal(?int $id = null)
    {
        $this->resetErrorBag();
        $this->editingSlideId = $id;

        if ($id) {
            $slide = LiveTvSlide::find($id);
            if ($slide) {
                $this->slideTitleAr     = $slide->title_ar ?? '';
                $this->slideTitleFr     = $slide->title_fr ?? '';
                $this->slideType        = $slide->slide_type ?? 'image';
                $this->slideContent     = $slide->content ?? '';
                $this->slideImageUrl    = $slide->image_url ?? '';
                $this->slideDurationSec = $slide->display_duration_sec ?? 10;
                $this->slideSortOrder   = $slide->sort_order ?? 1;
            }
        } else {
            $this->slideTitleAr     = '';
            $this->slideTitleFr     = '';
            $this->slideType        = 'image';
            $this->slideContent     = '';
            $this->slideImageUrl    = '';
            $this->slideDurationSec = 10;
            $this->slideSortOrder   = LiveTvSlide::max('sort_order') + 1;
        }

        $this->showSlideModal = true;
    }

    public function saveSlide()
    {
        $this->validate([
            'slideTitleAr'     => 'required|string|max:255',
            'slideDurationSec' => 'required|integer|min:3|max:120',
        ], [
            'slideTitleAr.required' => 'يرجى إدخال عنوان الشريحة.',
        ]);

        $data = [
            'title_ar'             => trim($this->slideTitleAr),
            'title_fr'             => trim($this->slideTitleFr),
            'slide_type'           => $this->slideType,
            'content'              => trim($this->slideContent),
            'image_url'            => trim($this->slideImageUrl),
            'display_duration_sec' => $this->slideDurationSec,
            'sort_order'           => $this->slideSortOrder,
        ];

        if ($this->editingSlideId) {
            $slide = LiveTvSlide::find($this->editingSlideId);
            if ($slide) {
                $slide->update($data);
            }
        } else {
            $data['is_active'] = true;
            LiveTvSlide::create($data);
        }

        $this->showSlideModal = false;
        session()->flash('message', 'تم حفظ شريحة البث المباشر بنجاح.');
    }

    public function toggleSlideStatus(int $id)
    {
        $slide = LiveTvSlide::find($id);
        if ($slide) {
            $slide->update(['is_active' => !$slide->is_active]);
        }
    }

    public function deleteSlide(int $id)
    {
        $slide = LiveTvSlide::find($id);
        if ($slide) {
            $slide->delete();
            session()->flash('message', 'تم حذف الشريحة.');
        }
    }

    public function render()
    {
        $announcements = LiveTvAnnouncement::latest()->get();
        $slides        = LiveTvSlide::orderBy('sort_order')->get();

        return view('livewire.admin.live-tv-index', [
            'announcements'         => $announcements,
            'slides'                => $slides,
            'liveStreamIsActive'    => $this->liveStreamIsActive,
            'showAnnouncementModal' => $this->showAnnouncementModal,
            'showSlideModal'        => $this->showSlideModal,
        ]);
    }
}
