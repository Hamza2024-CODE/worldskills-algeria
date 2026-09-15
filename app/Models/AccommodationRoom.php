<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationRoom extends Model
{
    protected $fillable = [
        'accommodation_id',
        'building',
        'floor',
        'room_number',
        'capacity',
        'gender',
        'status',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function allocations()
    {
        return $this->hasMany(RoomAllocation::class, 'room_id');
    }

    public function getOccupiedCountAttribute()
    {
        return $this->allocations()->where('status', 'CONFIRMED')->count();
    }
}
