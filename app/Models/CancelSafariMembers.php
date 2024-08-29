<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelSafariMembers extends Model
{
    use HasFactory;

    protected $table = "cancel_safari_members";

    protected $fillable = [

        'booking_id',
        'cancel_id',
        'name',
    ];
}
