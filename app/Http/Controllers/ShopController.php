<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    //


    public function index()
    {
        //newProducts là lấy ra sản phẩm mới tạo trong 7 ngày
        // $newProduct = Product::orderBy('created_at', 'desc')->first();
        $newProduct = Product::where('is_active', 1)->orderBy('created_at', 'desc')->first();
        $products = Product::where('is_active', 1)->orderBy('created_at', 'desc')->take(8)->get();
        $categories = Category::where('is_active', 1)->take(5)->get();
        return view('NiceShop.index', compact('newProduct', 'products', 'categories'));
    }

    public function search(Request $request)
    {
        $query = trim($request->input('query'));

        if (!$query) {
            return redirect()->back()->with('warning', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        $products = Product::where('is_active', 1)
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        return view('NiceShop.search', compact('products', 'query'));
    }


    public function show(string $slug)
    {
        $product = Product::where('is_active', 1)->where('slug', $slug)->first();
        return view('NiceShop.product-details', compact('product'));
    }


    public function category()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('NiceShop.category', compact('categories'));
    }

    public function addToCart(Request $request)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        //kiem tra so luong san pham trong kho
        $stock = Stock::where('on_hand', '>=', $quantity)
            ->where('product_id', $product_id)
            ->first();

        if ($stock) {
            $stock->on_hand -= $quantity;
            $stock->save();

            //kiem tra nguoi dung da co cart(gio hang) chua
            $cart = CartItems::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($cart) {
                $cart->quantity += $quantity;
                $cart->save();
            } else {
                CartItems::create([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                ]);
            }
            return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công');
        } else {
            return redirect()->back()->with('error', 'Kho hàng không đủ số lượng');
        }
    }
}
