<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $casts = [
        'websites' => 'array',
    ];

    public $fillable = [
        'name',
        'email',
        'phone',
        'address_1',
        'address_2',
        'state',
        'pincode',
        'gstin',
        'websites',
    ];

    public $timestamps = true;
}
