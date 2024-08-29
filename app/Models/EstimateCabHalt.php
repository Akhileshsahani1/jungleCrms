<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateCabHalt extends Model
{
    use HasFactory;

    protected $table = 'estimate_cab_halts';

    public $fillable = [
        'estimate_id',
        'estimate_cab_id',
        'halt',
        'start',
        'end',
    ];

    public $timestamps = true;  

    public function cab()
    {
        return $this->belongsTo(EstimateCab::class);
    }
}
