<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'order_id',
        'verified',
        'payment_method',
    ];


    protected $casts = [
        'payment_method' => PaymentMethod::class
    ];

}
