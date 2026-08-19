<?php

namespace App\Livewire\Public;

use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SkillEquipment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Skills extends Component
{
    public string $search = '';
    public string $selectedCategory = '';

    // Modal State
    public bool $showModal = false;
    public ?Skill $selectedSkill = null;
    public ?\App\Models\GuideSection $selectedGuideSection = null;
    public $selectedSkillEquipments = [];

    public function openSkillDetails(int $skillId): void
    {
        $this->selectedSkill = Skill::with(['category', 'assessmentModules.criteria'])->find($skillId);
        if ($this->selectedSkill) {
            $this->selectedSkillEquipments = SkillEquipment::with('equipmentItem')->where('skill_id', $skillId)->get();
            
            if (preg_match('/(?:SKILL|TD)-?(\d+)/i', $this->selectedSkill->code, $m)) {
                $prefix = 'td' . str_pad($m[1], 2, '0', STR_PAD_LEFT) . '_';
                $this->selectedGuideSection = \App\Models\GuideSection::where('section_key', 'like', $prefix . '%')->first();
            } else {
                $this->selectedGuideSection = null;
            }
            
            $this->showModal = true;
        }
    }

    public function openPdfViewer(int $skillId): void
    {
        $this->selectedSkill = Skill::with(['category', 'assessmentModules.criteria'])->find($skillId);
        if ($this->selectedSkill) {
            if (preg_match('/(?:SKILL|TD)-?(\d+)/i', $this->selectedSkill->code, $m)) {
                $prefix = 'td' . str_pad($m[1], 2, '0', STR_PAD_LEFT) . '_';
                $this->selectedGuideSection = \App\Models\GuideSection::where('section_key', 'like', $prefix . '%')->first();
            } else {
                $this->selectedGuideSection = null;
            }

            $pdfUrl = $this->selectedSkill->getPdfUrl();
            $pdfTitle = $this->selectedSkill->code . ' — ' . $this->selectedSkill->getLocalized('name');
            $this->dispatch('open-pdf-viewer', pdfUrl: $pdfUrl, pdfTitle: $pdfTitle);
        }
    }

    public function closeSkillDetails(): void
    {
        $this->showModal = false;
        $this->selectedSkill = null;
        $this->selectedGuideSection = null;
        $this->selectedSkillEquipments = [];
    }

    public function render()
    {
        $categories = SkillCategory::orderBy('name_ar')->get();

        $skills = Skill::with('category')
            ->where('is_active', true)
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('name_ar', 'like', "%{$this->search}%")
                    ->orWhere('code', 'like', "%{$this->search}%")
                    ->orWhere('name_fr', 'like', "%{$this->search}%")
                    ->orWhere('name_en', 'like', "%{$this->search}%");
            }))
            ->orderBy('sort_order')
            ->orderBy('code')
            ->get();

        return view('livewire.public.skills', [
            'categories' => $categories,
            'skills'     => $skills,
        ]);
    }
}
