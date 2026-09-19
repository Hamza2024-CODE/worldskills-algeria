<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Edition extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'year',
        'name_ar',
        'name_fr',
        'name_en',
        'is_active',
        'status',
        'theme_config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'theme_config' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($edition) {
            if (empty($edition->uuid)) {
                $edition->uuid = (string) Str::uuid();
            }
        });
    }

    public function dates()
    {
        return $this->hasMany(EditionDate::class);
    }

    public function countries()
    {
        return $this->hasMany(EditionCountry::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
