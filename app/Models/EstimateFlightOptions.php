<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateFlightOptions extends Model
{
    use HasFactory;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }
     public function flight()
    {
        return $this->belongsTo(EstimateFlight::class);
    }
}
