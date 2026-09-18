<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasTranslations;
    protected $fillable = [
        'uuid',
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'type',
        'country_id',
        'wilaya_id',
        'commune_id',
        'email',
        'phone',
        'address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($org) {
            if (empty($org->uuid)) {
                $org->uuid = (string) Str::uuid();
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }


    public function participantProfiles()
    {
        return $this->hasMany(ParticipantProfile::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
