<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancellationCharges extends Model
{
    use HasFactory;

    public function cancellationcharges()
    {
        return $this->hasMany(CancellationCharges::class, 'booking_cancellation_charge_id');
    }
}
