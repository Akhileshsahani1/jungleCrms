<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingReminder extends Model
{
    use HasFactory;
    
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
