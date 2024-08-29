<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    protected $table = 'terms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'mode',
        'type',
        'filter',
        'content',
    ];

    public $timestamps = true;
    
    public function destinations()
    {
        return $this->belongsTo(EstimateDestination::class);
    }
}
