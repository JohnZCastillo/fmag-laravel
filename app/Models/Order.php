<?php

namespace App\Models;

use App\Enums\CheckoutType;
use App\Enums\OrderState;
use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'state',
        'checkout_type',
        'user_id',
        'reference',
        'refunded'
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'state' => OrderState::class,
        'checkout_type' => CheckoutType::class,
    ];

    protected static function booted()
    {
        static::created(function ($request) {
            $request->reference = 'ORDR' . '-' . str_pad($request->id, 3, "0", STR_PAD_LEFT);;
            $request->save();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(OrderDelivery::class);
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(ProductFeedback::class, 'order_id', 'id');
    }

    public function canReview($productID)
    {
        return !$this->feedbacks->contains('product_id', $productID);
    }

}
