<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\FeedbackAttachment;
use App\Models\Order;
use App\Models\ProductFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{

    public function addComment(Request $request, $productID)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'content' => 'required|string|max:100|min:10',
                'rating' => 'required|numeric|min:1|max:5',
                'files.*' => 'file|mimes:jpeg,jpg,png,mp4',
                'files' => 'array|max:5',
            ]);

            $orderTotal = Order::select([DB::raw('count(id) as total')])
                ->where('status', OrderStatus::COMPLETED->value)
                ->where('user_id', Auth::id())
                ->with(['items'])
                ->whereHas(
                    'items', function ($query) use ($productID) {
                    $query->where('product_id', $productID);
                }
                )->value('total');

            $commentTotal = ProductFeedback::select([DB::raw('count(id) as total')])
                ->where('product_id', $productID)
                ->where('user_id', Auth::id())
                ->value('total');

            if ($commentTotal >= $orderTotal) {
                throw new \Exception('you haven\'t bought this item, please order first to comment');
            }


            if (!session('order_feedback_id')) {

                $feedbackOrderIDs = ProductFeedback::where('user_id', Auth::id())
                    ->pluck('order_id')
                    ->toArray();

                $orderID = Order::select(['id'])
                    ->where('user_id', Auth::id())
                    ->where('status', OrderStatus::COMPLETED->value)
                    ->whereNotIn('id', array_values($feedbackOrderIDs))
                    ->pluck('id')
                    ->first();

                session(['order_feedback_id' => $orderID]);

            }

            $feedback = ProductFeedback::create([
                'product_id' => $productID,
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'comment' => $validated['content'],
                'order_id' => session()->get('order_feedback_id'),
            ]);

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $filename = $file->store('public');

                    $attachment = new FeedbackAttachment();

                    $attachment->file = $filename;
                    $attachment->feedback_id = $feedback->id;

                    if ($file->extension() == 'mp4') {
                        $attachment->type = 'video';
                    }

                    $attachment->save();
                }
            }

            DB::commit();

            session()->forget('order_feedback_id');

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }
}
