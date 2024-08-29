<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancellationCharges extends Model
{
    use HasFactory;

     public function bookingcancellationcharges()
    {
        return $this->belongsTo(BookingCancellationCharges::class);
    }
}
