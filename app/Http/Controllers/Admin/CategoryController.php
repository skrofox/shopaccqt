<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:150|unique:categories,slug',
            'image' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        Category::create([
            'name' => $valid['name'],
            'slug' => $valid['slug'],
            'image' => $valid['image'] ?? null,
            'is_active' => (bool)($valid['is_active'] ?? false),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Tạo danh mục thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Không dùng trong admin hiện tại
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $valid = $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:150|unique:categories,slug,' . $category->id,
            'image' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $category->name = $valid['name'];
        $category->slug = $valid['slug'];
        $category->image = $valid['image'] ?? null;
        $category->is_active = (bool)($valid['is_active'] ?? false);
        $category->save();

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công');
    }
}
