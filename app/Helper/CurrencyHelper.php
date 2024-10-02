<?php

namespace App\Helper;

class CurrencyHelper
{
    public static function formatCurrency($amount): string
    {
        return number_format($amount, 2);
    }
}
