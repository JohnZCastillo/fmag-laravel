<?php

namespace App\Http\Controllers;

use App\Models\FeedbackAttachment;
use App\Models\ProductFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{

    public function addComment(Request $request, $productID)
    {
        try {

            $validated = $request->validate([
                'content' => 'required|string',
                'rating' => 'required|numeric',
                'files.*' => 'file|mimes:jpeg,jpg,png,mp4',
                'files' => 'array|max:5',
            ]);

            DB::beginTransaction();

            $feedback = ProductFeedback::create([
                'product_id' => $productID,
                'user_id' => Auth::id(),
                'rating' => $validated['rating'],
                'comment' => $validated['content'],
            ]);

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

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'something went wrong while submitting feedback']);
        }
    }
}
