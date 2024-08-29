<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateDestination extends Model
{
    use HasFactory;

    protected $table = 'estimate_destinations';

    public $fillable = [
        'destination',
    ];

    public $timestamps = true;

    public function inclusions()
    {
        return $this->hasMany(Inclusion::class,'destination_id');
    }
    public function exclusions()
    {
        return $this->hasMany(Exclusion::class,'destination_id');
    }
    public function terms()
    {
        return $this->hasMany(Term::class,'destination_id');
    }
}
