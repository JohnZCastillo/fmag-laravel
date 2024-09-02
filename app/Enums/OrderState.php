<?php

namespace App\Enums;

enum OrderState: string
{

    use Identity;

    case PENDING = 'pending';
    case PAYMENT = 'payment';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
}
