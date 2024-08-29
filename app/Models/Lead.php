<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'leads';

    public $fillable = [
        'name',
        'email',
        'mobile',
        'website',
        'meta',
        'date',
        'time',
        'lead_status',
        'payment_status',
        'assigned_to',
        'date_assigned',
        'source',
        'dob',           
        'anniversary',
        'more_details',
        'address',
        'meal_plan',
        'total_traveller',
        'travel_date',
        'assigned_by',
        'view',
        'destination'
    ];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

     public function deleted_user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function comments()
    {
        return $this->hasMany(LeadComment::class);
    }

    public function reminders()
    {
        return $this->hasMany(LeadReminder::class);
    }

    public function estimate()
    {
        return $this->hasOne(Estimate::class);
    }
    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
    public function leadfollowup()
    {
        return $this->hasMany(LeadFollowUp::class);
    }
}
