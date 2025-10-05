<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::paginate(20)->groupBy('order_code');
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order_code)
    {
        $orders = Order::where('order_code', $order_code)->get();
        $orderInfo = $orders->first();
        return view('admin.orders.show', compact('orders', 'orderInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $order_code)
    {
        $order = Order::where('order_code', $order_code);

        if ($order) {
            // Order::where('order_code', $order_code)->delete();
            $order->delete();
        }

        return back()->with('success', 'Xoa don hang thanh cong');
    }

    public function updateStatus($order_code)
    {
        $order = Order::where('order_code', $order_code);

        if ($order) {
            $order->update([
                'status' => request('status'),
            ]);
        }

        return back()->with('success', 'Cap nhat trang thai thanh cong ' . "Ma Don: $order_code");
    }
}
