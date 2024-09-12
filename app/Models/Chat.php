<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'sender_id',
        'receiver_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }
}
