<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateHotelDestination extends Model
{
    use HasFactory;
    protected $table = 'estimate_hotel_destinations';

    public $fillable = [
        'estimate_id',
        'estimate_hotel_id',
        'destination',
        'check_in',
        'check_out',
        'accepted',
    ];

    public $timestamps = true;

    public function options()
    {
        return $this->hasMany(EstimateHotelDestinationOption::class, 'destination_id');
    }
}
