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
            $url = self::resolveFileUrl($this->user->avatar_path);
            if ($url) return $url;
        }

        $photoDoc = $this->documents?->whereIn('document_type', ['PHOTO', 'photo', 'official_photo'])->first();
        if ($photoDoc?->file_path) {
            $url = self::resolveFileUrl($photoDoc->file_path);
            if ($url) return $url;
        }

        if (!empty($this->participant?->photo_path)) {
            $url = self::resolveFileUrl($this->participant->photo_path);
            if ($url) return $url;
        }

        $name = $this->participant?->first_name_ar ?? $this->user?->name ?? 'Candidate';
        $initial = mb_substr(trim($name), 0, 1);
        return "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'><rect width='200' height='200' rx='40' fill='%2306205C'/><text x='50%' y='55%' dominant-baseline='middle' text-anchor='middle' font-family='Arial, sans-serif' font-size='85' font-weight='bold' fill='%23FFFFFF'>{$initial}</text></svg>";
    }

    public static function resolveFileUrl(?string $path): ?string
    {
        if (!$path) return null;
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:image')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }
        $cleanPath = ltrim($cleanPath, '/');

        $storageAppPath = storage_path('app/public/' . $cleanPath);
        $publicStoragePath = public_path('storage/' . $cleanPath);

        if (file_exists($storageAppPath) && !file_exists($publicStoragePath)) {
            @mkdir(dirname($publicStoragePath), 0755, true);
            @copy($storageAppPath, $publicStoragePath);
        }

        if (file_exists($publicStoragePath) && !file_exists($storageAppPath)) {
            @mkdir(dirname($storageAppPath), 0755, true);
            @copy($publicStoragePath, $storageAppPath);
        }

        if (file_exists($publicStoragePath) || file_exists($storageAppPath)) {
            return asset('storage/' . $cleanPath);
        }

        return null;
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

    public function result()
    {
        return $this->hasOne(CompetitionResult::class, 'registration_id');
    }
}
