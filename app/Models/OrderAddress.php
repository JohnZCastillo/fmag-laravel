<?php

namespace App\Models;

use App\Interfaces\AddressInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderAddress extends Model implements AddressInterface
{
    use HasFactory;

    protected $fillable = [
        'region',
        'province',
        'city',
        'barangay',
        'order_id',
        'shipping_fee',
        'address'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getRegion(): int
    {
        return $this->region;
    }

    public function getProvince(): int
    {
        return $this->province;
    }

    public function getCity(): int
    {
        return $this->city;
    }

    public function getBarangay(): int
    {
        return $this->barangay;
    }


    public function getProperty()
    {
      return '123';
    }
}
