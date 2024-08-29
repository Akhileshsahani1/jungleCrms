<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHotel extends Model
{
    use HasFactory;

    protected $table = 'booking_hotel';

    public $fillable = [
        'booking_id',
        'adult',
        'child',
        'room',
        'bed',
        'check_in',
        'check_out',
        'destination',
        'amount',
        'hotel_id',
        'room_id',
        'service_id',
        'note',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function option()
    {
        return $this->hasOne(BookingHotelDestinationOption::class, 'booking_hotel_id');
    }
}
