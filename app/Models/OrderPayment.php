<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'order_id',
        'verified',
        'payment_method',
        'file',
        'message',
    ];


    protected $casts = [
        'payment_method' => PaymentMethod::class
    ];

    public function receipts(): HasOne
    {
        return $this->hasOne(PaymentProof::class);
    }

}
