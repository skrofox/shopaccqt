<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stock::with(['product', 'product.category']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('slug', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'low':
                    $query->whereRaw('on_hand <= min_stock');
                    break;
                case 'high':
                    $query->whereRaw('on_hand >= max_stock');
                    break;
                case 'normal':
                    $query->whereRaw('on_hand > min_stock AND on_hand < max_stock');
                    break;
            }
        }

        if ($request->has('category') && $request->category) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        $stocks = $query->paginate(20);
        $products = Product::with('category')->whereDoesntHave('stocks')->get();

        return view('admin.stocks.index', compact('stocks', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $products = Product::with('category')->whereDoesntHave('stocks')->get();
        // return view('admin.stocks.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id|unique:stocks,product_id',
            'on_hand' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
        ], [
            'product_id.required' => 'Vui lòng chọn sản phẩm',
            'product_id.exists' => 'Sản phẩm không tồn tại',
            'product_id.unique' => 'Sản phẩm này đã có dữ liệu tồn kho',
            'on_hand.required' => 'Vui lòng nhập số lượng tồn kho',
            'on_hand.integer' => 'Số lượng tồn kho phải là số nguyên',
            'on_hand.min' => 'Số lượng tồn kho không thể âm',
            'min_stock.required' => 'Vui lòng nhập số lượng tối thiểu',
            'min_stock.integer' => 'Số lượng tối thiểu phải là số nguyên',
            'min_stock.min' => 'Số lượng tối thiểu không thể âm',
            'max_stock.required' => 'Vui lòng nhập số lượng tối đa',
            'max_stock.integer' => 'Số lượng tối đa phải là số nguyên',
            'max_stock.min' => 'Số lượng tối đa không thể âm',
        ]);

        // Additional validation
        if ($request->max_stock <= $request->min_stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng tối đa phải lớn hơn số lượng tối thiểu'
            ]);
        }

        $stock = Stock::create([
            'product_id' => $request->product_id,
            'on_hand' => $request->on_hand,
            'min_stock' => $request->min_stock,
            'max_stock' => $request->max_stock,
        ]);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Tạo mới tốn kho thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = Stock::with(['product', 'product.category', 'product.images'])
            ->findOrFail($id);

        return view('admin.stocks.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     $stock = Stock::with(['product', 'product.category'])->findOrFail($id);
    //     return view('admin.stocks.edit', compact('stock'));
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stock = Stock::findOrFail($id);

        $request->validate([
            'on_hand' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'max_stock' => 'required|integer|min:0',
        ], [
            'on_hand.required' => 'Vui lòng nhập số lượng tồn kho',
            'on_hand.integer' => 'Số lượng tồn kho phải là số nguyên',
            'on_hand.min' => 'Số lượng tồn kho không thể âm',
            'min_stock.required' => 'Vui lòng nhập số lượng tối thiểu',
            'min_stock.integer' => 'Số lượng tối thiểu phải là số nguyên',
            'min_stock.min' => 'Số lượng tối thiểu không thể âm',
            'max_stock.required' => 'Vui lòng nhập số lượng tối đa',
            'max_stock.integer' => 'Số lượng tối đa phải là số nguyên',
            'max_stock.min' => 'Số lượng tối đa không thể âm',
        ]);

        if ($request->max_stock <= $request->min_stock) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Số lượng tối đa phải lớn hơn số lượng tối thiểu');
        }

        $stock->update([
            'on_hand' => $request->on_hand,
            'min_stock' => $request->min_stock,
            'max_stock' => $request->max_stock,
        ]);

        return redirect()->route('admin.stocks.index')
            ->with('success', 'Cập nhật tồn kho thành công!');
    }
    public function destroy(string $id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $productName = $stock->product->name;

            DB::beginTransaction();
            $stock->delete();
            DB::commit();

            return redirect()->route('admin.stocks.index')
                ->with('success', "Xóa tồn kho của sản phẩm '{$productName}' thành công!");
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }


    /**
     * Get stock statistics
     */
    public function statistics()
    {
        $totalProducts = Stock::count();
        $lowStockCount = Stock::whereRaw('on_hand <= min_stock')->count();
        $highStockCount = Stock::whereRaw('on_hand >= max_stock')->count();
        $normalStockCount = Stock::whereRaw('on_hand > min_stock AND on_hand < max_stock')->count();

        $stats = [
            'total' => $totalProducts,
            'low' => $lowStockCount,
            'high' => $highStockCount,
            'normal' => $normalStockCount,
        ];

        return response()->json($stats);
    }

    /**
     * Update stock quantity (for inventory adjustments)
     */
    public function adjustQuantity(Request $request, $id)
    {
        $request->validate([
            'adjustment' => 'required|integer',
            'type' => 'required|in:increase,decrease',
            'reason' => 'nullable|string|max:255'
        ]);

        try {
            DB::beginTransaction();

            $stock = Stock::findOrFail($id);
            $oldQuantity = $stock->on_hand;

            if ($request->type === 'increase') {
                $stock->on_hand += $request->adjustment;
            } else {
                $newQuantity = $stock->on_hand - $request->adjustment;
                if ($newQuantity < 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể giảm số lượng xuống dưới 0'
                    ]);
                }
                $stock->on_hand = $newQuantity;
            }

            $stock->save();

            // Log the adjustment (you can create a StockMovement model for this)
            // StockMovement::create([
            //     'stock_id' => $stock->id,
            //     'type' => $request->type,
            //     'quantity' => $request->adjustment,
            //     'old_quantity' => $oldQuantity,
            //     'new_quantity' => $stock->on_hand,
            //     'reason' => $request->reason,
            //     'created_by' => auth()->id(),
            // ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Điều chỉnh tồn kho thành công!',
                'stock' => $stock
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Export stocks to CSV
     */
    public function export()
    {
        $stocks = Stock::with(['product', 'product.category'])->get();

        $filename = 'stocks_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($stocks) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($file, [
                'ID',
                'Sản phẩm',
                'Danh mục',
                'Tồn kho',
                'Tối thiểu',
                'Tối đa',
                'Trạng thái',
                'Ngày tạo',
                'Ngày cập nhật'
            ]);

            // Data
            foreach ($stocks as $stock) {
                $status = 'Bình thường';
                if ($stock->on_hand <= $stock->min_stock) {
                    $status = 'Thấp';
                } elseif ($stock->on_hand >= $stock->max_stock) {
                    $status = 'Cao';
                }

                fputcsv($file, [
                    $stock->id,
                    $stock->product->name,
                    $stock->product->category->name,
                    $stock->on_hand,
                    $stock->min_stock,
                    $stock->max_stock,
                    $status,
                    $stock->created_at->format('d/m/Y H:i:s'),
                    $stock->updated_at->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get low stock alerts
     */
    public function getLowStockAlerts()
    {
        $lowStocks = Stock::with(['product', 'product.category'])
            ->whereRaw('on_hand <= min_stock')
            ->orderBy('on_hand', 'asc')
            ->get();

        return response()->json([
            'count' => $lowStocks->count(),
            'stocks' => $lowStocks
        ]);
    }

    /**
     * Bulk update stocks
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'stocks' => 'required|array',
            'stocks.*.id' => 'required|exists:stocks,id',
            'stocks.*.on_hand' => 'required|integer|min:0',
            'stocks.*.min_stock' => 'required|integer|min:0',
            'stocks.*.max_stock' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            $updated = 0;
            $errors = [];

            foreach ($request->stocks as $stockData) {
                if ($stockData['max_stock'] <= $stockData['min_stock']) {
                    $errors[] = "Sản phẩm ID {$stockData['id']}: Số lượng tối đa phải lớn hơn tối thiểu";
                    continue;
                }

                Stock::where('id', $stockData['id'])->update([
                    'on_hand' => $stockData['on_hand'],
                    'min_stock' => $stockData['min_stock'],
                    'max_stock' => $stockData['max_stock'],
                ]);

                $updated++;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Cập nhật thành công {$updated} sản phẩm",
                'errors' => $errors
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
