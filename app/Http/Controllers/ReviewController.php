<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //
    public function store($order, Request $request) {}

    public function quick_assessment($id, Request $request)
    {
        // Review::create([
        //     'user_id' => Auth::id(),
        //     'product_id' => $id,
        //     'content' => $request->input('assessment'),
        //     'rating' => $request->input('rating'),
        // ]);
        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $id
            ],
            [
                'content' => $request->input('assessment'),
                'rating' => $request->input('rating')
            ]
        );

        return redirect()->back()->with([
            'open_modal' => true,
            'success' => 'Đã gửi đi đánh giá'
        ]);
    }
    public function delete_review($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with(['success' => 'Đã xóa đánh giá.', 'open_modal' => true,]);
    }
}
