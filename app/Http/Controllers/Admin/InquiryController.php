<?php

namespace App\Http\Controllers\Admin;

use App\Events\InquiryEvent;
use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use App\Models\ServiceInquiry;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{

    public function index()
    {

        $inquiries = ServiceInquiry::where('viewed', false)
            ->with(['service', 'user'])
            ->paginate();

        return view('admin.inquiries', [
            'inquiries' => $inquiries
        ]);
    }

    public function inquire($serviceID)
    {

        try {
            DB::beginTransaction();

            $serviceInquiry = ServiceInquiry::create([
                'service_id' => $serviceID,
                'user_id' => Auth::id()
            ]);

            DB::commit();

            InquiryEvent::dispatch($serviceInquiry);

            return redirect()->back()->with(['message' => 'inquiry success']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'unable to inquire for this service']);
        }
    }

    public function viewInquiry(ServiceInquiry $serviceInquiry)
    {

        try {
            DB::beginTransaction();

            $serviceInquiry->viewed = true;

            $serviceInquiry->save();

            DB::commit();

            return redirect()->back()->with(['message' => 'inquiry viewed']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'unable to view this inquiry']);
        }
    }

}
