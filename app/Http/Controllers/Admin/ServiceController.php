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

        $services = Service::where('archived', false)
            ->paginate();

        return view('admin.services', [
            'services' => $services
        ]);
    }

    public function add(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'acronym' => 'required',
                'title' => 'required',
                'video' => 'required|mimes:mp4',
            ]);

            $service = new Service();

            if ($request->hasFile('video')) {
                $filename = $request->file('video')->store('public');

                if (!$filename) {
                    throw new \Exception('unable to save video');
                }

                $service->video = $filename;
            }

            $service->title = $validated['title'];
            $service->acronym = $validated['acronym'];

            $service->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'service added']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'id' => 'required',
                'acronym' => 'required',
                'title' => 'required',
                'video' => 'nullable|mimes:mp4',
            ]);

            $service = Service::findOrFail($validated['id']);

            if ($request->hasFile('video')) {
                $filename = $request->file('video')->store('public');

                if (!$filename) {
                    throw new \Exception('unable to save video');
                }

                $service->video = $filename;
            }

            $service->title = $validated['title'];
            $service->acronym = $validated['acronym'];

            $service->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'service updated']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function archived(Request $request, $serviceID)
    {

        try {

            DB::beginTransaction();

            $service = Service::findOrFail($serviceID);
            $service->archive = true;
            $service->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'service  archived']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function getService($serviceID)
    {

        try {

            $service = Service::findOrFail($serviceID);

            return response()->json($service);

        } catch (\Exception $e) {
            return response()->json($service,500);
        }
    }
}
