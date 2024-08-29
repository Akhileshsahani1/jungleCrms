<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelRoom extends Model
{
    use HasFactory;

    protected $table = 'hotel_rooms';

    public $fillable = ['hotel_id', 'room'];

    public $timestamps = true;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function services()
    {
        return $this->hasMany(HotelRoomService::class, 'room_id');
    }
}
