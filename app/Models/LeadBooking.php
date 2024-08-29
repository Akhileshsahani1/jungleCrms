<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'address',
        'state',
        'taxable_amount',
        'non_taxable_amount',
        'booking_type',
    ];

    public $timestamps = true;
}
