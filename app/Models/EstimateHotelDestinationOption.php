<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateHotelDestinationOption extends Model
{
    use HasFactory;

    protected $table = 'estimate_hotel_destination_options';

    public $fillable = [
        'destination_id',
        'estimate_id',
        'estimate_hotel_id',
        'hotel_id',
        'room_id',
        'service_id',
        'amount',
        'discount',
        'total',
    ];

    public $timestamps = true;



    public function destination()
    {
        return $this->belongsTo(EstimateHotelDestinationOption::class);
    }

    public function hotel()
    {
        return $this->belongsTo(EstimateHotel::class);
    }
}
