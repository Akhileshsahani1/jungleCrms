<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalAddress extends Model
{
    use HasFactory;

    protected $table = 'local_address';

    public $fillable = [
        'sanctuary',
        'name',
        'address_1',
        'address_2',
        'state',
        'pincode',
    ];

    public $timestamps = true;
}
