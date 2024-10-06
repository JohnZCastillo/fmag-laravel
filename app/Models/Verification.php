<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'code',
        'expiration'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
