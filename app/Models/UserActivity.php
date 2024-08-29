<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'comment',
    ];

    public function activities()
    {
        return $this->hasmany(UserActivity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
