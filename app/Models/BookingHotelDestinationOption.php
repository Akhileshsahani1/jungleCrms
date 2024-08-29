<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHotelDestinationOption extends Model
{
    use HasFactory;

    protected $table = 'booking_hotel_destination_options';

    public $fillable = [
        'destination_id',
        'booking_id',
        'booking_hotel_id',
        'hotel_id',
        'room_id',
        'service_id',
    ];

    public $timestamps = true;

    public function destination()
    {
        return $this->belongsTo(BookingHotelDestinationOption::class);
    }

     public function hotel()
    {
        return $this->belongsTo(BookingHotel::class);
    }
}
