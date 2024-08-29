<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancellationRequest extends Model
{
    use HasFactory;

    public $fillable = [
        'customer_id',
        'booking_id',
        'reason',
        'cancellation_charges',
        'refundable_amount',
        'status',
        'approval_amount',
        'approval_status',
        'cancel_status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function refund_history(){

        return $this->hasMany(RefundHistory::class, 'cancellation_id')->latest();

    }
}
