<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'image',
        'category_id',
        'archived',
    ];

    protected $casts = [
        'archived' => 'boolean'
    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(ProductFeedback::class);
    }

}
