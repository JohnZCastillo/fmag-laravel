<?php

namespace App\View\Components;

use App\Models\Address\Barangay;
use App\Models\Address\City;
use App\Models\Address\Province;
use App\Models\Address\Region;
use App\Models\UserAddress;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class EditAddress extends Component
{

    protected UserAddress $address;

    public function __construct(UserAddress $address)
    {
        $this->address = $address;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $regions = Region::select(['region_name', 'region_code'])
            ->get();
//
        $provinces = Province::select(['province_name', 'province_code'])
            ->where('region_code', $this->address->region)
            ->get();


        $cities = City::select(['city_name', 'city_code'])
            ->where('province_code', $this->address->province)
            ->get();

        $barangays = Barangay::select(['brgy_name', 'brgy_code'])
            ->where('city_code', $this->address->city)
            ->get();


        return view('components.edit-address', [
            'myAddress' => $this->address,
            'regions' => $regions,
            'provinces' => $provinces,
            'cities' => $cities,
            'barangays' => $barangays
        ]);
    }
}
