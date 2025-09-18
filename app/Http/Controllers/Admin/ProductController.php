<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|nullable',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        //Xu ly anh (neu co)
        $imagePath = null;
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                // $fileName = time() . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imagePath = $imageFile->store('products', 'public');

                ProductImage::create([
                    'name' => $imagePath,
                    'product_id' => $product->id,
                    'url' => Storage::url($imagePath),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm mới thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa Sản Phẩm ');
    }
    public function trash(){
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.products.trash', compact('products'));
    }
}
