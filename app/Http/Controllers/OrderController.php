<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    //
    public function order_success($order_code)
    {
        $user = Auth::user()->load('infos');
        $orders = Order::where('user_id', $user->id)
            ->where('order_code', $order_code)
            ->with('product')
            ->get();

        // $product_might = Product::where('category_id', $order)

        if ($orders->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Không tìm thấy đơn hàng này');
        }

        return view('NiceShop.order-confirmation', compact('user', 'orders', 'order_code'));
    }
}
