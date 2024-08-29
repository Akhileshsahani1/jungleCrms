<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSafariCustomer extends Model
{
    use HasFactory;

    protected $table ='booking_safari_customers';
    public $fillable = [
        'booking_id',
        'name',
        'age',
        'gender',
        'nationality',
        'state',
        'jeep_no',
        'idproof',
        'idproof_no'
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
