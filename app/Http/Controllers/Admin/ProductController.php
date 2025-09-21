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
    public function index(Request $request)
    {
        //
        $query = $request->input('query');
        $products = Product::query();

        if ($query) {
            $products = Product::when($query, function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });
        }

        $products = $products->paginate(10);
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
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = Str::slug($request->name) . '-' . time() . '-' . uniqid();

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
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
                    'url' => $imagePath,
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
        $product = Product::with(['category', 'images'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $slug = Str::slug($request->name) . '-' . time() . '-' . uniqid();
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $imageFile) {
                $imagePath = $imageFile->store('products', 'public');

                ProductImage::create([
                    'name' => $imagePath,
                    'product_id' => $product->id,
                    'url' => Storage::url($imagePath),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công');
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
    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.products.trash', compact('products'));
    }

    public function restore(string $id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')->with('success', 'Khôi phục sản phẩm thành công');
    }

    public function forceDelete(string $id)
    {
        $product = Product::onlyTrashed()->with('images')->findOrFail($id);

        foreach ($product->images as $image) {
            if ($image->name && Storage::disk('public')->exists($image->name)) {
                Storage::disk('public')->delete($image->name);
            }
            $image->delete();
        }

        $product->forceDelete();
        return redirect()->route('admin.products.trash')->with('success', 'Đã xóa vĩnh viễn sản phẩm');
    }
}
