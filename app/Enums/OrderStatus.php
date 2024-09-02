<?php

namespace App\Enums;

enum OrderStatus: string
{

    use Identity;

    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case DELIVERY = 'out for delivery';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
}
