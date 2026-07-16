<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'events';

    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'banner',
        'lokasi',
        'kapasitas',
        'harga',
        'tanggal',
        'jam',
        'kategori',
        'status',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'harga' => 'integer',
    ];

    /**
     * The organizer who created this event.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Registrations for this event.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id');
    }

    /**
     * Get the remaining quota for this event.
     */
    public function getSisaKuotaAttribute(): int
    {
        $registered = $this->registrations()->count();
        return max(0, $this->kapasitas - $registered);
    }

    /**
     * Get the count of registered participants.
     */
    public function getRegisteredCountAttribute(): int
    {
        return $this->registrations()->count();
    }

    /**
     * Scope: only published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'Published');
    }

    /**
     * Scope: search by judul.
     */
    public function scopeCari($query, $search)
    {
        if ($search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        }
        return $query;
    }

    /**
     * Scope: filter by kategori.
     */
    public function scopeKategori($query, $kategori)
    {
        if ($kategori) {
            return $query->where('kategori', $kategori);
        }
        return $query;
    }
}
