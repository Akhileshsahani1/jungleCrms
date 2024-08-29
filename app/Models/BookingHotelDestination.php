<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingHotelDestination extends Model
{
    use HasFactory;
    protected $table = 'booking_hotel_destinations';

    public $fillable = [
        'booking_id',
        'booking_hotel_id',
        'destination',
        'check_in',
        'check_out',
        'accepted',
    ];

    public $timestamps = true;

    public function options()
    {
        return $this->hasMany(BookingHotelDestinationOption::class, 'destination_id');
    }
}
