<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    protected  $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $appends = ['sub_total'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubTotalAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }
}
