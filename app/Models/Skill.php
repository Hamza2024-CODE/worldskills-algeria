<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skill extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'code',
        'category_id',
        'name_ar',
        'name_fr',
        'name_en',
        'description_ar',
        'description_fr',
        'description_en',
        'icon',
        'image_path',
        'pdf_path',
        'min_age',
        'max_age',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_age' => 'integer',
        'max_age' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            if (empty($skill->uuid)) {
                $skill->uuid = (string) Str::uuid();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }

    public function skillEquipments()
    {
        return $this->hasMany(SkillEquipment::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getPdfUrl(): ?string
    {
        // 1. If explicit pdf_path is stored and file exists
        if (!empty($this->pdf_path)) {
            $cleanPath = ltrim($this->pdf_path, '/');
            if (str_starts_with($cleanPath, 'http://') || str_starts_with($cleanPath, 'https://')) {
                return $cleanPath;
            }
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
        }

        // 2. Try TD number matching (e.g. SKILL-39 -> WSC2026_TD39_en.pdf)
        $num = null;
        if (preg_match('/(\d+)/', $this->code, $m)) {
            $num = str_pad($m[1], 2, '0', STR_PAD_LEFT);
        } elseif ($this->sort_order && $this->sort_order >= 1 && $this->sort_order <= 64) {
            $num = str_pad($this->sort_order, 2, '0', STR_PAD_LEFT);
        } elseif ($this->id && $this->id >= 1 && $this->id <= 64) {
            $num = str_pad($this->id, 2, '0', STR_PAD_LEFT);
        }

        if ($num) {
            $filename = "WSC2026_TD{$num}_en.pdf";
            if (file_exists(public_path('docs/td/' . $filename))) {
                return asset('docs/td/' . $filename);
            }
        }

        // 3. Try code matching (e.g. WSC2026_SKILL-39_en.pdf)
        if (!empty($this->code)) {
            $codeFilename = "WSC2026_{$this->code}_en.pdf";
            if (file_exists(public_path('docs/td/' . $codeFilename))) {
                return asset('docs/td/' . $codeFilename);
            }
        }

        return null;
    }

    public function getImageUrl(): string
    {
        if (!empty($this->image_path)) {
            if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
                return $this->image_path;
            }
            $cleanPath = ltrim($this->image_path, '/');
            if (file_exists(public_path($cleanPath))) {
                return asset($cleanPath);
            }
        }

        return match((int) $this->category_id) {
            1 => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=80',
            2 => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?w=800&auto=format&fit=crop&q=80',
            3 => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&auto=format&fit=crop&q=80',
            4 => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&auto=format&fit=crop&q=80',
            5 => 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=800&auto=format&fit=crop&q=80',
            6 => 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80',
            default => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=800&auto=format&fit=crop&q=80',
        };
    }

    public function assessmentModules()
    {
        return $this->hasMany(CompetitionAssessmentModule::class);
    }
}
