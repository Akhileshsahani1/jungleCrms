<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateIternary extends Model
{
    protected $table = 'estimate_iternaries';

    public $fillable = [
        'estimate_id',
        'title',
        'text',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
