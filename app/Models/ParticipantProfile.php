<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ParticipantProfile extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'user_id',
        'first_name_ar',
        'last_name_ar',
        'first_name_fr',
        'last_name_fr',
        'first_name_en',
        'last_name_en',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'national_id',
        'passport_number',
        'passport_expiry',
        'wilaya_id',
        'commune_id',
        'organization_id',
        'photo_hash',
        'document_hash',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($profile) {
            if (empty($profile->uuid)) {
                $profile->uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wilaya()
    {
        return $this->belongsTo(Wilaya::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'participant_id');
    }
}
