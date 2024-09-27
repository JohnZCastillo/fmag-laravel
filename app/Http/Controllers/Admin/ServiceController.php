<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{

    public function index()
    {

        $services = Service::paginate();

        return view('admin.services', [
            'services' => $services
        ]);
    }

    public function add(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required',
                'video' => 'required|mimes:mp4',
            ]);

            $service = new Service();

            if($request->hasFile('video')){
                $filename = $request->file('video')->store('public');

                if(!$filename){
                    throw new \Exception('unable to save video');
                }

                $service->video = $filename;
            }

            $service->title = $validated['title'];

            $service->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'service added']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
