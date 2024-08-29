<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateSafari extends Model
{
    use HasFactory;

    protected $table = 'estimate_safari';

    public $fillable = [
        'estimate_id',
        'sanctuary',
        'mode',
        'zone',
        'area',
        'adult',
        'child',
        'total_person',
        'nationality',
        'vehicle_type',
        'type',
        'date',
        'time',
        'note',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
}
