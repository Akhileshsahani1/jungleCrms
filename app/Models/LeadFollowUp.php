<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lead_id',
        'datetime',
        'comment',
        'done',
    ];

     public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
