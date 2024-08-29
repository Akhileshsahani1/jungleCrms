<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSafariPermit extends Model
{
    use HasFactory;

    protected $table ='booking_safari_permits';
    public $fillable = [
        'booking_id',
        'safari_id',
        'permit',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
