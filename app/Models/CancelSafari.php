<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelSafari extends Model
{
    use HasFactory;

    protected $table = "cancel_safari";

    protected $fillable = [

        'booking_id',
        'customer_id',
        'amount',
        'cancellation_charges',
        'refund_amount'
    ];

    public function members(){

        return $this->hasMany(CancelSafariMembers::class,'cancel_id','id');
    }
}
