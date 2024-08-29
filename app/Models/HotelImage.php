<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    use HasFactory;

    protected $table = 'hotel_images';

    public $fillable = ['hotel_id', 'image'];

    public $timestamps = true;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

}
