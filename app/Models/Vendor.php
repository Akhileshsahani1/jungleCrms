<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    public $fillable = [
        'sanctuary',
        'default',
        'name',
        'email',
        'phone',
        'alternate',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function safari()
    {
        return $this->belongsTo(BookingSafari::class);
    }

    public $timestamps = true;
}
