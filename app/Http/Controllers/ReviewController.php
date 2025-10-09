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
        $request->validate([
            'order_code' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'assessment' => 'nullable|string',
        ]);

        $orderCode = $request->input('order_code');

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $id,
                'order_code' => $orderCode,
            ],
            [
                'content' => $request->input('assessment'),
                'rating' => $request->input('rating'),
            ]
        );

        return redirect()->back()->with([
            'open_modal' => true,
            'rating_order_code' => $orderCode,
            'success' => 'Đã gửi đi đánh giá',
        ]);
    }
    public function delete_review($id)
    {
        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $orderCode = $review->order_code;
        $review->delete();

        return redirect()->back()->with([
            'success' => 'Đã xóa đánh giá.',
            'open_modal' => true,
            'rating_order_code' => $orderCode,
        ]);
    }
    public function helpful($id)
    {
        $review = Review::findOrFail($id);
        $review->increment('helpful_vote');
        return back()->with('message', 'Cảm ơn bạn đã đánh giá hữu ích!');
    }
}
