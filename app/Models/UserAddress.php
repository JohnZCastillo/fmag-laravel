<?php

namespace App\Models;

use App\Interfaces\AddressInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model implements AddressInterface
{
    use HasFactory;

    protected $fillable = [
        'region',
        'province',
        'city',
        'barangay',
        'postal',
        'property',
        'active',
        'shipping_fee',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
