<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundTransaction extends Model
{
    use HasFactory;
    protected $table = 'refund_transaction';

     public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
