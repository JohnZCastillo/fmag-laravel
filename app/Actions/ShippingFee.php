<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class ShippingFee
{
    use AsAction;

    public function handle($provinceID): float
    {
        return $provinceID == '0421' ? 50 : 150;
    }
}
