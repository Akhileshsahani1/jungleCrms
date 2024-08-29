<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateCab extends Model
{
    use HasFactory;

    protected $table = 'estimate_cab';

    public $fillable = [
        'estimate_id',
        'trip_type',
        'pickup_medium',
        'vehicle_type',
        'start_date',
        'end_date',
        'days',
        'pick_up',
        'drop',
        'pickup_time',
        'total_riders',
        'note'
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function halts()
    {
        return $this->hasMany(EstimateCabHalt::class, 'estimate_cab_id');
    }
}
