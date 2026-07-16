<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Support\Str;

class Registration extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'registrations';

    protected $fillable = [
        'event_id',
        'user_id',
        'registration_code',
        'status',
        'registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    /**
     * The event this registration belongs to.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * The participant who registered.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Generate a unique registration code.
     * Format: EVT-YYYYMMDD-XXXX
     */
    public static function generateCode(): string
    {
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(4));
        $code = "EVT-{$date}-{$random}";

        // Ensure uniqueness
        while (self::where('registration_code', $code)->exists()) {
            $random = strtoupper(Str::random(4));
            $code = "EVT-{$date}-{$random}";
        }

        return $code;
    }
}
