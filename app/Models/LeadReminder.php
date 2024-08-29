<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'datetime',
        'comment',
        'seen',
        'sender',
        'receiver',
    ];

    public $timestamps = true;

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

}
