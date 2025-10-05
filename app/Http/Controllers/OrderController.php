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


        if ($orders->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Không tìm thấy đơn hàng này');
        }

        return view('NiceShop.order-confirmation', compact('user', 'orders', 'order_code'));
    }

    public function order_received($order_code)
    {
        $order = Order::where('order_code', $order_code)
            ->where('status', 'processing');

        if ($order) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'completed',
            ]);
            return back()->with('success', 'Da nhan duoc hang');
        } else {
            return back()->with('error', 'Loi!');
        }
    }

    public function cancelled_order($order_code)
    {
        $order = Order::where('order_code', $order_code);

        if ($order) {
            $order->update([
                'status' => 'cancelled',
            ]);
            return back()->with('success', 'Da huy don hang');
        } else {
            return back()->with('error', 'Loi!');
        }
    }
}
