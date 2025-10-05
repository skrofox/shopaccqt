<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function category(Request $request)
    {
        $categories = Category::where('is_active', 1)->get();
        $products = Product::orderByDesc('created_at')->paginate(9);

        if($query = $request->query('query')){
            if($query != null){
                $category = Category::where('slug', $query)->orderByDesc('created_at')->first();
                $products = Product::where('category_id', $category->id)->orderByDesc('created_at')->paginate(10);

                if(!$category){
                    return redirect()->back()->withErrors('Khong tim thay danh muc')->withInput();
                }
            }
        }

        // $products = Product::paginate(9);
        return view('NiceShop.category', compact('categories', 'products'));
    }
}
