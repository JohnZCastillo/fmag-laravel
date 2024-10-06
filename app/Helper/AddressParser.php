<?php

namespace App\Helper;

use App\Interfaces\AddressInterface;
use App\Models\Address\Barangay;
use App\Models\Address\City;
use App\Models\Address\Province;
use App\Models\Address\Region;

class AddressParser
{
    public static function parseRegion(int $code): string
    {
        try {

            $region = Region::select(['region_name'])->where('region_code', $code)
                ->first();

            return $region->region_name;
        } catch (\Exception $e) {
            return '';
        }
    }

    public static function parseProvince(int $code): string
    {
        try {

            $province = Province::select(['province_name'])->where('province_code', $code)
                ->first();

            return $province->province_name;

        } catch (\Exception $e) {
            return '';
        }
    }

    public static function parseCity(int $code): string
    {
        try {

            $city = City::select(['city_name'])->where('city_code', $code)
                ->first();

            return $city->city_name;

        } catch (\Exception $e) {
            return '';
        }
    }

    public static function parseBarangay(int $code): string
    {
        try {

            $brgy = Barangay::select(['brgy_name'])->where('brgy_code', $code)
                ->first();

            return $brgy->brgy_name;

        } catch (\Exception $e) {
            return '';
        }
    }

    public static function parseAddress(AddressInterface $address): string
    {

        $location = $address->getProperty() . ', ';
        $location .= self::parseBarangay($address->getBarangay()) . ', ';
        $location .= self::parseCity($address->getCity()) . ' ';
        $location .= self::parseProvince($address->getProvince()) . ', ';
        $location .= self::parseRegion($address->getRegion());

        return strtolower($location);
    }
}
