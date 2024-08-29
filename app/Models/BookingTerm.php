<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingTerm extends Model
{
    use HasFactory;

    protected $table = 'booking_terms';

    public $fillable = [
        'booking_id',
        'content',
        'filter',
    ];

    public $timestamps = true;

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
