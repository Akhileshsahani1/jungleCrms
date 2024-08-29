<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateSafariOption extends Model
{
    use HasFactory;

    protected $table = 'estimate_safari_options';

    public $fillable = [
        'estimate_id',
        'estimate_safari_id',
        'content',
        'amount',
        'discount',
        'total',
        'accepted',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
