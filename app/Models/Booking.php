<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'from_date',
        'to_date',
        'total_amount',
        'admin_commission',
        'service_charge',
        'owner_payout',
        'status',
        'payment_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
