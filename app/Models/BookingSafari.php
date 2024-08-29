<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSafari extends Model
{
    use HasFactory;

    protected $table = 'booking_safari';

    public $fillable = [
        'booking_id',
        'sanctuary',
        'mode',
        'zone',
        'area',
        'adult',
        'child',
        'total_person',
        'nationality',
        'vehicle_type',
        'type',
        'date',
        'time',
        'amount',
        'note',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'vendor_id');
    }
}
