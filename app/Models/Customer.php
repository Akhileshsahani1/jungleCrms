<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    public $fillable = [
        'name',
        'email',
        'mobile',
        'address',
        'state',
        'company',
        'gstin',
        'dob',           
        'anniversary',
        'more_details',
        'meal_plan',
        'total_traveller',
        'travel_date'
    ];

    public $timestamps = true;

    public function estimates()
    {
        return $this->hasMany(Estimate::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function tickets()
    {
        return $this->hasMany(Support::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'estimate_id');
    }

    public function cancellationRequest()
    {
        return $this->hasMany(BookingCancellationRequest::class, 'booking_id');
    }
}
