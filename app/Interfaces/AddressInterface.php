<?php

namespace App\Interfaces;

interface AddressInterface
{

    public function getRegion(): int;

    public function getProvince(): int;

    public function getCity(): int;

    public function getBarangay(): int;
    public function getProperty();

}
