<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address\Barangay;
use App\Models\Address\City;
use App\Models\Address\Province;
use App\Models\Address\Region;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserAddressController extends Controller
{

    public function index()
    {
        $addresses = UserAddress::where('user_id', Auth::id())
            ->orderBy('active', 'DESC')
            ->paginate(10);

        return view('user.address', [
            'addresses' => $addresses,
        ]);
    }

    public function viewAddress(UserAddress $userAddress)
    {

        $regions = Region::select(['region_name', 'region_code'])
            ->get();

        $provinces = Province::select(['province_name', 'province_code'])
            ->where('region_code', $userAddress->region)
            ->get();


        $cities = City::select(['city_name', 'city_code'])
            ->where('province_code', $userAddress->province)
            ->get();

        $barangays = Barangay::select(['brgy_name', 'brgy_code'])
            ->where('city_code', $userAddress->city)
            ->get();


        return view('user.edit-address', [
            'myAddress' => $userAddress,
            'regions' => $regions,
            'provinces' => $provinces,
            'cities' => $cities,
            'barangays' => $barangays
        ]);

    }


    public function newAddressForm()
    {
        return view('user.add-address');
    }

    public function registerAddress(Request $request)
    {

        try {

            $validated = $request->validate([
                'region' => 'required|numeric',
                'province' => 'required|numeric',
                'city' => 'required|numeric',
                'barangay' => 'required|numeric',
                'postal' => 'nullable|numeric',
                'property' => 'required|string',
            ]);

            DB::beginTransaction();

            $address = new UserAddress();

            $address->region = $validated['region'];
            $address->province = $validated['province'];
            $address->city = $validated['city'];
            $address->barangay = $validated['barangay'];
            $address->property = $validated['property'];
            $address->user_id = Auth::id();

            if (isset($validated['postal'])) {
                $address->postal = $validated['postal'];
            }

            $address->save();

            DB::commit();

            return redirect('/address');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message', $e->getMessage()]);
        }

    }

    public function editAddress(Request $request, UserAddress $userAddress)
    {

        try {

            $validated = $request->validate([
                'region' => 'required|numeric',
                'province' => 'required|numeric',
                'city' => 'required|numeric',
                'barangay' => 'required|numeric',
                'postal' => 'nullable|numeric',
                'property' => 'required|string',
            ]);


            DB::beginTransaction();

            $userAddress->fill(array_filter($validated));

            $userAddress->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'Address updated!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while updating address']);
        }

    }

    public function setDefaultAddress(UserAddress $userAddress)
    {

        try {

            DB::beginTransaction();

            UserAddress::where('user_id', Auth::id())
                ->update(['active' => false]);

            $userAddress->active = true;
            $userAddress->save();

            DB::commit();

            return redirect('/address');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message', $e->getMessage()]);
        }
    }

}
