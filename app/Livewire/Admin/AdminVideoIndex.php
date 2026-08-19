<?php

namespace App\Livewire\Admin;

use App\Models\Video;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminVideoIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    public string $title_ar       = '';
    public string $title_fr       = '';
    public string $title_en       = '';
    public string $video_type     = 'YOUTUBE';
    public string $video_url      = '';
    public string $embed_url      = '';
    public string $description_ar = '';
    public string $duration       = '';
    public bool   $is_featured    = false;
    public string $status         = 'PUBLISHED';

    // Drawer
    public bool   $drawerOpen    = false;
    public ?Video $selectedVideo = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId    = null;

    protected $queryString = ['search', 'filterType', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterType(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function syncFromChannel(): void
    {
        try {
            $importer = new \App\Services\YouTubeChannelImporterService();
            $res = $importer->importFromChannelHandle('@WorldSkillsAlgeria');
            $this->resetPage();
            $msg = $res['message'] ?? 'تم استيراد الفيديوهات بنجاح';
            $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
            session()->flash('message', $msg);
        } catch (\Throwable $e) {
            $this->dispatch('notify', ['type' => 'error', 'msg' => 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage()]);
            session()->flash('error', 'حدث خطأ أثناء الاستيراد: ' . $e->getMessage());
        }
    }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $v = Video::find($id);
        if (!$v) {
            $this->dispatch('notify', ['type' => 'error', 'msg' => 'لم يتم العثور على الفيديو']);
            return;
        }

        $this->editingId      = $id;
        $this->title_ar       = $v->title_ar ?? '';
        $this->title_fr       = $v->title_fr ?? '';
        $this->title_en       = $v->title_en ?? '';
        $this->video_type     = $v->video_type ?? 'YOUTUBE';
        $this->video_url      = $v->video_url ?? '';
        $this->embed_url      = $v->embed_url ?? '';
        $this->description_ar = $v->description_ar ?? '';
        $this->duration       = (string)($v->duration ?? '');
        $this->is_featured    = (bool)$v->is_featured;
        $this->status         = $v->status ?? 'PUBLISHED';
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function closeForm(): void
    {
        $this->formOpen = false;
        $this->resetForm();
    }

    public function save(): void
    {
        if ($this->video_url && !str_starts_with($this->video_url, 'http://') && !str_starts_with($this->video_url, 'https://')) {
            $this->video_url = 'https://' . $this->video_url;
        }

        $this->validate([
            'title_ar'   => 'required|min:3',
            'title_fr'   => 'required|min:3',
            'video_url'  => 'required|url',
            'video_type' => 'required',
        ], [
            'title_ar.required'  => 'يرجى إدخال عنوان الفيديو بالعربية',
            'title_ar.min'       => 'عنوان الفيديو بالعربية يجب أن يكون 3 أحرف على الأقل',
            'title_fr.required'  => 'يرجى إدخال عنوان الفيديو بالفرنسية',
            'title_fr.min'       => 'عنوان الفيديو بالفرنسية يجب أن يكون 3 أحرف على الأقل',
            'video_url.required' => 'يرجى إدخال رابط الفيديو',
            'video_url.url'      => 'رابط الفيديو غير صالح، يرجى كتابة رابط كامل مثل https://youtube.com/watch?v=...',
            'video_type.required'=> 'يرجى اختيار نوع الفيديو',
        ]);

        $embed = $this->embed_url;
        $thumb = null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches)) {
            $youtubeId = $matches[1];
            if (empty($embed)) {
                $embed = "https://www.youtube.com/embed/{$youtubeId}";
            }
            $thumb = "https://img.youtube.com/vi/{$youtubeId}/hqdefault.jpg";
        }

        $data = [
            'title_ar'       => $this->title_ar,
            'title_fr'       => $this->title_fr,
            'title_en'       => $this->title_en ?: $this->title_fr,
            'video_type'     => $this->video_type,
            'video_url'      => $this->video_url,
            'embed_url'      => $embed ?: $this->video_url,
            'description_ar' => $this->description_ar,
            'duration'       => $this->duration,
            'is_featured'    => $this->is_featured,
            'status'         => $this->status,
            'published_at'   => $this->status === 'PUBLISHED' ? now() : null,
        ];

        if ($thumb) {
            $data['thumbnail_path'] = $thumb;
        }

        if ($this->isEditing && $this->editingId) {
            Video::where('id', $this->editingId)->update($data);
            $msg = 'تم تحديث الفيديو بنجاح';
        } else {
            Video::create($data);
            $msg = 'تم إضافة الفيديو بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
        session()->flash('message', $msg);
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedVideo = Video::find($id);
        $this->drawerOpen    = true;
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen    = false;
        $this->selectedVideo = null;
    }

    /* ─── Delete ─── */
    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteConfirmOpen = false;
        $this->deleteTargetId    = null;
    }

    public function deleteVideo(): void
    {
        if ($this->deleteTargetId) {
            Video::where('id', $this->deleteTargetId)->delete();
            $msg = 'تم حذف الفيديو بنجاح';
            $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
            session()->flash('message', $msg);
        }
        $this->deleteConfirmOpen = false;
        $this->deleteTargetId    = null;
        $this->resetPage();
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->title_ar       = '';
        $this->title_fr       = '';
        $this->title_en       = '';
        $this->video_type     = 'YOUTUBE';
        $this->video_url      = '';
        $this->embed_url      = '';
        $this->description_ar = '';
        $this->duration       = '';
        $this->is_featured    = false;
        $this->status         = 'PUBLISHED';
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Video::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('title_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('title_en', 'like', '%'.$this->search.'%')
                  ->orWhere('video_url', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterType,   fn($q) => $q->where('video_type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status',     $this->filterStatus))
            ->latest();

        return view('livewire.admin.cms.video-index', [
            'videos'      => $query->paginate(12),
            'totalVideos' => Video::count(),
        ]);
    }
}

