<?php

namespace App\Models;

use App\Enums\ParticipantStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $fillable = [
        'uuid',
        'registration_number',
        'verification_token',
        'edition_id',
        'participant_id',
        'country_id',
        'skill_id',
        'status',
        'suit_size',
        'shoe_size',
        'height_cm',
        'national_id_pdf_path',
        'passport_pdf_path',
        'issued_at',
        'expires_at',
        'revoked_at',
        'revoked_by',
        'revocation_reason',
        'submitted_at',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'status' => ParticipantStatus::class,
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'issued_at' => 'datetime',
        'expires_at' => 'datetime',
        'revoked_at' => 'datetime',
        'height_cm' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($reg) {
            if (empty($reg->uuid)) {
                $reg->uuid = (string) Str::uuid();
            }
            if (empty($reg->verification_token)) {
                $reg->verification_token = Str::random(40);
            }
            if (empty($reg->registration_number)) {
                $countryIso = $reg->country ? $reg->country->iso2 : 'DZ';
                $reg->registration_number = 'WSAP-' . date('Y') . '-' . $countryIso . '-' . rand(100000, 999999);
            }
        });
    }

    public function getPhotoUrlAttribute(): string
    {
        if ($this->user?->avatar_path) {
            return self::resolveFileUrl($this->user->avatar_path);
        }

        $photoDoc = $this->documents?->whereIn('document_type', ['PHOTO', 'photo', 'official_photo'])->first();
        if ($photoDoc?->file_path) {
            return self::resolveFileUrl($photoDoc->file_path);
        }

        if (!empty($this->participant?->photo_path)) {
            return self::resolveFileUrl($this->participant->photo_path);
        }

        $name = $this->participant?->first_name_ar ?? $this->user?->name ?? 'Candidate';
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=06205C&color=fff&bold=true&size=200';
    }

    public static function resolveFileUrl(?string $path): string
    {
        if (!$path) return '';
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        return asset('storage/' . ltrim($cleanPath, '/'));
    }

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    public function participant()
    {
        return $this->belongsTo(ParticipantProfile::class, 'participant_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function documents()
    {
        return $this->hasMany(ParticipantDocument::class);
    }

    public function revokedByUser()
    {
        return $this->belongsTo(User::class, 'revoked_by');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, ParticipantProfile::class, 'id', 'id', 'participant_id', 'user_id');
    }

    public function wilaya()
    {
        return $this->hasOneThrough(Wilaya::class, ParticipantProfile::class, 'id', 'id', 'participant_id', 'wilaya_id');
    }

    public function organization()
    {
        return $this->hasOneThrough(Organization::class, ParticipantProfile::class, 'id', 'id', 'participant_id', 'organization_id');
    }
}
