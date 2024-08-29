<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'type',
        'comment',
        'comment_by',
    ];

    public $timestamps = true;

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
}
