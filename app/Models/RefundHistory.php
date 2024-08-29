<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundHistory extends Model
{
    use HasFactory;

    protected $table = 'refund_history';

    protected $fillable = [
        'booking_id',
        'customer_id',
        'cancellation_id',
        'admin_id',
        'amount',
        'note',
        'status'
    ];
}
