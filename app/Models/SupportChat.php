<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'support_id',
        'sender',
        'message',
        'seen'
    ];

    public function support()
    {
        return $this->belongsTo(Support::class);
    }
}
