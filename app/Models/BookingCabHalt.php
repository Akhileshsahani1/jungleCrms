<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCabHalt extends Model
{
    use HasFactory;

    protected $table = 'booking_cab_halts';

    public $fillable = [
        'booking_id',
        'booking_cab_id',
        'halt',
        'start',
        'end',
    ];

    public $timestamps = true;  

    public function cab()
    {
        return $this->belongsTo(BookingCab::class);
    }
}
