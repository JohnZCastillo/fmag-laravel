<?php

namespace App\Enums;

enum PaymentMethod: string
{
    use Identity;

    case CASH = 'cash';
    case GCASH = 'gcash';
}
