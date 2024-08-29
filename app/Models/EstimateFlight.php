<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFlight extends Model
{
    use HasFactory;

     public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function flight_options()
    {
        return $this->hasMany(EstimateFlightOptions::class, 'estimate_flight_id');
    }
}
