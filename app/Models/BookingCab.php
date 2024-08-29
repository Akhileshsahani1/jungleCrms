<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCab extends Model
{
    use HasFactory;
    protected $table = 'booking_cab';

    public $fillable = [
        'booking_id',
        'trip_type',
        'pickup_medium',
        'vehicle_type',
        'start_date',
        'end_date',
        'days',
        'pick_up',
        'drop',
        'pickup_time',
        'total_riders',
        'amount',
        'note'
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function halts()
    {
        return $this->hasMany(BookingCabHalt::class, 'booking_cab_id');
    }
}
