<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotels';

    protected $fillable = [

        'name',
        'email',
        'phone',
        'person',
        'rating',
        'address',
        'state',
        'city',
        'status',
    ];

    public $timestamps = true;

    public function images()
    {
        return $this->hasMany(HotelImage::class, 'hotel_id');
    }

    public function rooms()
    {
        return $this->hasMany(HotelRoom::class, 'hotel_id');
    }
}
