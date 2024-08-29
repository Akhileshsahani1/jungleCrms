<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateHotelOption extends Model
{
    use HasFactory;

    protected $table = 'estimate_hotel_options';

    public $fillable = [
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

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
