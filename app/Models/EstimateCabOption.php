<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateCabOption extends Model
{
    use HasFactory;

    protected $table = 'estimate_cab_options';

    public $fillable = [
        'estimate_id',
        'estimate_cab_id',
        'content',
        'amount',
        'discount',
        'total',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
