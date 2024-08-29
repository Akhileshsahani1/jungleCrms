<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateHotel extends Model
{
    use HasFactory;

    protected $table = 'estimate_hotel';

    public $fillable = [
        'estimate_id',
        'adult',
        'child',
        'room',
        'bed',
        'check_in',
        'check_out',
        'destination',
        'note',
        'inclusion_filter',
        'term_filter',
    ];

    public $timestamps = true;

    public function estimate()
    {
        return $this->belongsTo(Estimate::class);
    }

    public function option()
    {
        return $this->hasOne(EstimateHotelDestinationOption::class, 'estimate_hotel_id');
    }
}
