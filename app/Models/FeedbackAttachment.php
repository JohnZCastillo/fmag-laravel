<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file',
        'feedback_id'
    ];

    public function feedback(): BelongsTo
    {
        return $this->belongsTo(ProductFeedback::class, 'feedback_id', 'id');
    }
}
