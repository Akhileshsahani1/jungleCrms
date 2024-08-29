<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoomService extends Model
{
    use HasFactory;

    protected $table = 'hotel_room_services';

    public $fillable = ['hotel_id', 'room_id', 'service', 'price', 'extra_adult_price', 'extra_child_price', 'weekend_price', 'extra_adult_weekend_price', 'extra_child_weekend_price'];

    public $timestamps = true;

    public function room()
    {
        return $this->belongsTo(HotelRoom::class);
    }
}
