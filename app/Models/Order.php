<?php

namespace App\Models;

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

    protected $casts = [
        'status' => OrderStatus::class,
        'state' => OrderState::class,
    ];

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

}