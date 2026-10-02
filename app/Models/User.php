<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'avatar_path',
        'password',
        'country_id',
        'wilaya_id',
        'organization_id',
        'is_active',
        'can_scan_qr',
        'must_change_password',
        'last_login_at',
        'locale',
    ];

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path) {
            $url = \App\Models\Registration::resolveFileUrl($this->avatar_path);
            if ($url) return $url;
        }

        $participantPhoto = $this->participant?->registrations?->first()?->photo_url;
        if ($participantPhoto) {
            return $participantPhoto;
        }

        $initial = mb_substr(trim($this->name ?: 'U'), 0, 1);
        return "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200' viewBox='0 0 200 200'><rect width='200' height='200' rx='40' fill='%2306205C'/><text x='50%' y='55%' dominant-baseline='middle' text-anchor='middle' font-family='Arial, sans-serif' font-size='85' font-weight='bold' fill='%23FFFFFF'>{$initial}</text></svg>";
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'    => 'datetime',
            'last_login_at'        => 'datetime',
            'password'             => 'hashed',
            'is_active'            => 'boolean',
            'can_scan_qr'          => 'boolean',
            'must_change_password' => 'boolean',
        ];
    }

    public function canScanQr(): bool
    {
        if ($this->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }
        return (bool) $this->can_scan_qr;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
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

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function competitionAssignments()
    {
        return $this->hasMany(CompetitionAssignment::class, 'user_id');
    }

    public function participant()
    {
        return $this->hasOne(ParticipantProfile::class, 'user_id');
    }

    public function badges()
    {
        return $this->hasMany(Badge::class, 'user_id');
    }
}
