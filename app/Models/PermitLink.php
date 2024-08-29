<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermitLink extends Model
{
    use HasFactory;

     protected $casts = [
        'booking_ids' => 'array',
    ];

    protected $table ='booking_safari_permit_links';
    public $fillable = [
        'slug',
        'date',
        'booking_ids',
    ];

    public $timestamps = true;
}
