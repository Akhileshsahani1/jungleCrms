<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimate extends Model
{
    use SoftDeletes;
    protected $casts = [
        'payment_modes' => 'array',
    ];

    public $fillable = [
        'type',
        'customer_id',
        'lead_id',
        'assigned_to',
        'source',
        'payment_status',
        'estimate_status',
        'date',
        'time',
        'gst_filed',
        'pg_charges_filed',
        'payment_modes',
        'payment_type',
    ];

    public $timestamps = true;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function userdelete()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function cab()
    {
        return $this->hasOne(EstimateCab::class, 'estimate_id');
    }

    public function cabs()
    {
        return $this->hasMany(EstimateCab::class, 'estimate_id');
    }

    public function cab_options()
    {
        return $this->hasMany(EstimateCabOption::class, 'estimate_id');
    }

    public function flight()
    {
        return $this->hasOne(EstimateFlight::class, 'estimate_id');
    }

    public function flights()
    {
        return $this->hasMany(EstimateFlight::class, 'estimate_id');
    }

    public function flight_options()
    {
        return $this->hasMany(EstimateFlightOptions::class, 'estimate_id');
    }


    public function hotel()
    {
        return $this->hasOne(EstimateHotel::class, 'estimate_id');
    }

    public function hotels()
    {
        return $this->hasMany(EstimateHotel::class, 'estimate_id');
    }

    public function hotel_options()
    {
        return $this->hasMany(EstimateHotelOption::class, 'estimate_id');
    }

    public function safari()
    {
        return $this->hasOne(EstimateSafari::class, 'estimate_id');
    }

    public function safaris()
    {
        return $this->hasMany(EstimateSafari::class, 'estimate_id');
    }

    public function safari_options()
    {
        return $this->hasMany(EstimateSafariOption::class, 'estimate_id');
    }

    public function inclusions()
    {
        return $this->hasMany(EstimateInclusion::class, 'estimate_id');
    }

    public function exclusions()
    {
        return $this->hasMany(EstimateExclusion::class, 'estimate_id');
    }
    public function halts()
    {
        return $this->hasMany(EstimateCabHalt::class, 'estimate_id');
    }
    public function iternaries()
    {
        return $this->hasMany(EstimateIternary::class, 'estimate_id');
    }

    public function terms()
    {
        return $this->hasMany(EstimateTerm::class, 'estimate_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'estimate_id');
    }

    public function destinations()
    {
        return $this->hasMany(EstimateHotelDestination::class, 'estimate_id');
    }

}
