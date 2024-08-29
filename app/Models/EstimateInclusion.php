<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateInclusion extends Model
{
    use HasFactory;
    protected $table = 'estimate_inclusions';

    public $fillable = [
        'estimate_id',
        'content',
        'filter',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
