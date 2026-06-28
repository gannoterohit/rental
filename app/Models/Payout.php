<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'owner_id',
        'booking_id',
        'amount',
        'status',
        'release_date',
        'payment_reference',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}

