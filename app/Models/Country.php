<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'iso2',
        'iso3',
        'name_ar',
        'name_fr',
        'name_en',
        'nationality_ar',
        'nationality_fr',
        'nationality_en',
        'phone_code',
        'flag',
        'is_african',
        'is_algeria',
        'requires_passport',
        'requires_national_id',
        'is_active',
    ];

    protected $casts = [
        'is_african' => 'boolean',
        'is_algeria' => 'boolean',
        'requires_passport' => 'boolean',
        'requires_national_id' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getCodeAttribute(): string
    {
        return $this->iso2 ?? $this->iso3 ?? '';
    }

    public function scopeWhereCode($query, string $code)
    {
        return $query->where('iso2', $code)->orWhere('iso3', $code);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($country) {
            if (empty($country->uuid)) {
                $country->uuid = (string) Str::uuid();
            }
        });
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function delegations()
    {
        return $this->hasMany(CountryDelegation::class);
    }

    public function editionCountries()
    {
        return $this->hasMany(EditionCountry::class);
    }
}
