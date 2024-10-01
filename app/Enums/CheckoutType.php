<?php

namespace App\Enums;

enum CheckoutType: string
{

    use Identity;

    case CART = 'cart';
    case PRODUCT = 'product';
}
