<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralSettingController extends Controller
{

    public function index()
    {
        $settings = GeneralSetting::findOrFail(1);

        return view('admin.general-settings', [
            'settings' => $settings
        ]);

    }

    public function update(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'logo' => 'nullable',
                'mobile' => 'required',
                'fb' => 'nullable',
                'address' => 'required',
                'host' => 'nullable',
                'email' => 'nullable',
                'password' => 'nullable',
                'policy' => 'required',
            ]);

            $settings = GeneralSetting::findOrFail(1);

            //remove null inputs
            $validated = array_filter($validated);

            $settings->fill($validated);

            if ($request->hasFile('logo')) {

                $filename = $request->file('logo')->store('public');

                if (!$filename) {
                    throw new \Exception('an error occurred while saving logo');
                }

                $settings->logo = $filename;

            }

            $settings->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'updated success']);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['message' => 'an error occurred while updating general settings']);
        }
    }
}
