<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancel extends Model
{
    use HasFactory;
    protected $table = 'booking_cancel';
    public $fillable = [
        'booking_id',
        'reason',
        'cancellation_charges',
        'permit_cancellation_charges',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
