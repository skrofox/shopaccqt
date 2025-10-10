<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Category;
use App\Models\InfoUser;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    //


    public function index()
    {
        //newProducts là lấy ra sản phẩm mới tạo trong 7 ngày
        $newProduct = Product::where('is_active', 1)->orderByDesc('created_at')->first();
        $products = Product::where('is_active', 1)->orderBy('created_at', 'desc')->take(8)->get();
        $categories = Category::where('is_active', 1)->take(5)->get();

        return view('NiceShop.index', compact('newProduct', 'products', 'categories'));
    }

    public function account()
    {
        $user = Auth::user()->load('infos');
        $orders = Order::where('user_id', $user->id)
            ->with('product')
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('order_code');
        $reviews = Review::where('user_id', $user->id)
            ->get()
            ->keyBy('product_id');
        // dd($reviews);
        return view('NiceShop.account', compact('user', 'orders', 'reviews'));
    }

    public function account_update(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        $user->update([
            'name'  => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        InfoUser::updateOrCreate(
            ['user_id' => $user->id],
            ['phone'   => $request->input('phone')]
        );

        return back()->with('success', 'Cập nhật thành công!');
    }


    public function contact()
    {
        return view('NiceShop.contact');
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
        $reviews = Review::where('product_id', $product->id)->get();

        $averageRating = round($reviews->avg('rating'), 1); // trung bình 1 số thập phân
        $totalReviews = $reviews->count();

        // đếm từng loại sao
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        // tính % cho thanh tiến trình
        $ratingPercents = [];
        foreach ($ratingCounts as $star => $count) {
            $ratingPercents[$star] = $totalReviews > 0
                ? round(($count / $totalReviews) * 100)
                : 0;
        }

        return view('NiceShop.product-details', compact(
            'product',
            'reviews',
            'averageRating',
            'totalReviews',
            'ratingCounts',
            'ratingPercents'
        ));

        // return view('NiceShop.product-details', compact('product', 'reviews'));
    }


    // public function category()
    // {
    //     $categories = Category::where('is_active', 1)->get();
    //     return view('NiceShop.category', compact('categories'));
    // }

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
            //kiem tra nguoi dung da co cart(gio hang) chua
            $cart = CartItem::where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();

            if ($cart) {
                $cart->quantity += $quantity;
                $cart->save();
            } else {
                CartItem::create([
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

    public function cart()
    {
        // $carts = CartItems::where('user_id', Auth::user()->id)->get();
        $carts = CartItem::with(['product.category', 'product.images', 'product.stocks'])
            ->where('user_id', Auth::id())
            ->get();

        return view('NiceShop.cart', compact('carts'));
    }

    // public function removeFromCart(string $id)
    // {
    //     $cart = CartItem::find($id);
    //     $cart->delete();
    //     return redirect()->back();
    // }
    public function removeFromCart(string $id)
    {
        $cart = CartItem::find($id);

        // Kiểm tra xem $cart có tồn tại hay không
        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        } else {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }
    }

    // public function login(){
    //     return view('NiceShop.login');
    // }

    // public function register(){
    //     return view('NiceShop.register');
    // }


    // public function cartUpdate(Request $request, $id)
    // {
    //     $cart = CartItem::where('id', $id)
    //         ->with('product')
    //         ->firstOrFail();

    //     $quantity = (int)$request->input('quantity');

    //     if ($quantity < 1) {
    //         return response()->json([
    //             'error' => 'Số lượng không hợp lệ',
    //         ], 422);
    //     }

    //     if ($quantity > $cart->product->stocks->on_hand) {
    //         return response()->json([
    //             'error' => 'Quá trớn rồi đó',
    //         ], 422);
    //     }
    //     // if ($quantity > $cart->product->stocks->on_hand) {
    //     //     return response()->json([
    //     //         'error' => 'Số lượng vượt quá tồn kho',
    //     //     ], 422);
    //     // }

    //     //Cập nhật cart
    //     $cart->quantity = $quantity;
    //     $cart->total_price = $cart->quantity * $cart->product->price;
    //     $cart->save();

    //     $cartTotal = CartItem::where('user_id', Auth::user()->id)->sum('total_price');

    //     return redirect()->back();
    // }
    public function cartUpdate(Request $request, $id)
    {
        $action = $request->input('action'); // "increase" hoặc "decrease"
        $quantity = (int) $request->input('quantity', 1);

        $cart = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('product.stocks')
            ->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng.');
        }

        if ($action === 'increase') {
            $cart->quantity = min($quantity, $cart->product->stocks->on_hand);
        } elseif ($action === 'decrease') {
            $cart->quantity = max($quantity, 1);
        }

        $cart->save();

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }


    public function checkout()
    {
        $user = Auth::user()->load('infos');
        $carts = CartItem::with(['product.category', 'product.images', 'product.stocks'])
            ->where('user_id', Auth::id())
            ->get();
        // dd($carts);
        return view('NiceShop.checkout', compact('carts', 'user'));
    }

    public function about()
    {
        return view('NiceShop.about');
    }

    // public function checkoutStore(Request $request)
    // {
    //     $request->validate([
    //         'address' => 'required|string|max:255',
    //         'phone' => 'required|max:10|string',
    //     ]);

    //     $user_id = Auth::user()->id;
    //     $carts = CartItem::where('user_id', $user_id)->get();
    //     $address = $request->input('address');
    //     $phone = $request->input('phone');

    //     $payment_method = $request->input('payment_method');
    //     if ($payment_method == 'cod') {
    //         $payment_method = 'Thanh toán trực tiếp';
    //     } elseif ($payment_method == 'ck') {
    //         $payment_method = 'Thanh toán trực tuyến';
    //     }

    //     foreach ($carts as $item) {
    //         $order = Order::create([
    //             'user_id' => $user_id,
    //             'product_id' => $item->product_id,
    //             'quantity' => $item->quantity,
    //             'total_price' => $item->total_price,
    //             'payment_method' => $payment_method,
    //         ]);
    //         $item->delete();

    //         $stocks = Stock::where('product_id', $item->product_id)->first();
    //         if ($stocks) {
    //             $stocks->on_hand -= $item->quantity;
    //             $stocks->save();
    //         }
    //     }


    //     if (Auth::user()->info->count() == 0) {
    //         InfoUser::create([
    //             'user_id' => $user_id,
    //             'address' => $address,
    //             'phone' => $phone,
    //         ]);
    //     }

    //     return redirect()->route('home')->with('success', 'Thanh toán thành công');
    // }
    public function checkoutStore(Request $request)
    {
        // Custom validation messages in Vietnamese
        $messages = [
            'name.required' => 'Tên khách hàng không được để trống',
            'name.string' => 'Tên khách hàng phải là chuỗi ký tự',
            'name.max' => 'Tên khách hàng không được vượt quá 255 ký tự',
            'address.required' => 'Địa chỉ không được để trống',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự',
            'address.max' => 'Địa chỉ không được vượt quá 500 ký tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự',
            'phone.regex' => 'Số điện thoại không đúng định dạng (phải có 10-11 chữ số)',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
            'agree_terms.accepted' => 'Bạn phải đồng ý với điều khoản dịch vụ',
        ];

        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'payment_method' => 'required|in:cod,ck',
            'agree_terms' => 'accepted',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Vui lòng kiểm tra lại thông tin đã nhập');
        }

        try {
            $user_id = Auth::user()->id;
            $carts = CartItem::where('user_id', $user_id)->get();

            // Kiểm tra giỏ hàng có rỗng không
            if ($carts->isEmpty()) {
                return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống');
            }

            // Lấy dữ liệu từ form
            $name = $request->input('name');
            $address = $request->input('address');
            $phone = $request->input('phone');
            $payment_method = $request->input('payment_method');
            $save_address = $request->boolean('save_address');

            // Xử lý payment method
            $payment_method_text = '';
            switch ($payment_method) {
                case 'cod':
                    $payment_method_text = 'Thanh toán khi nhận hàng';
                    break;
                case 'ck':
                    $payment_method_text = 'Chuyển khoản ngân hàng';
                    break;
                default:
                    $payment_method_text = 'Thanh toán khi nhận hàng';
            }

            // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
            $order_code = 'ORD-' . uniqid();
            foreach ($carts as $item) {
                // Kiểm tra sản phẩm còn tồn tại không
                if (!$item->product) {
                    throw new \Exception("Sản phẩm trong giỏ hàng không còn tồn tại");
                }

                // Kiểm tra tồn kho trước khi tạo đơn hàng
                $stock = Stock::where('product_id', $item->product_id)->first();
                if ($stock && $stock->on_hand < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$item->product->name}' chỉ còn {$stock->on_hand} trong kho, không đủ cho số lượng {$item->quantity} bạn yêu cầu");
                }


                // Tạo đơn hàng
                $order = Order::create([
                    'user_id' => $user_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                    'payment_method' => $payment_method_text,
                    'payment_status' => 'unpaid',
                    'order_code' => $order_code,
                ]);

                // Cập nhật tồn kho
                if ($stock) {
                    $stock->on_hand -= $item->quantity;
                    $stock->save();
                }
            }

            // Xóa giỏ hàng sau khi tạo đơn hàng thành công
            CartItem::where('user_id', $user_id)->delete();

            // Cập nhật hoặc tạo mới thông tin user nếu được yêu cầu
            if ($save_address) {
                $userInfo = InfoUser::firstOrNew(['user_id' => $user_id]);
                $userInfo->address = $address;
                $userInfo->phone = $phone;
                $userInfo->save();
            }

            // Redirect với thông báo thành công
            $successMessage = 'Đặt hàng thành công! ';
            if ($payment_method === 'ck') {
                $successMessage .= 'Vui lòng chuyển khoản theo thông tin đã cung cấp.';
            } else {
                $successMessage .= 'Đơn hàng sẽ được giao trong vòng 2-3 ngày làm việc.';
            }

            return redirect()->route('order-success', ['order_code' => $order_code])->with('success', $successMessage);
        } catch (\Exception $e) {
            // Log lỗi để debug
            // Log::error('Checkout error: ' . $e->getMessage(), [
            //     'user_id' => Auth::id(),
            //     'request_data' => $request->except(['_token']),
            // ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
