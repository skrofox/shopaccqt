<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('NiceShop.index');
// })->name('home');

Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/search-products', [ShopController::class, 'search'])->name('product-search');

Route::get('/category', [ShopController::class, 'category'])->name('category');

Route::get('/about', [ShopController::class, 'about'])->name('about');

Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');
// Route::get('/categories/{slug}', [ShopController::class, 'category'])->name('category');

// Route::get('/login', [ShopController::class, 'login'])->name('login');

// Route::get('/register', [ShopController::class, 'register'])->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //cart_item
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
    Route::post('/cart', [ShopController::class, 'addToCart'])->name('cart.action');
    Route::delete('/cart/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    // Route::post('/cart/checkout', [ShopController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/{id}/update', [ShopController::class, 'cartUpdate'])->name('cart.update');


    //checkout
    Route::get('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [ShopController::class, 'checkoutStore'])->name('checkout.store');
});

//Admin route

Route::middleware(['is_admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // Route::get('/search', [AdminController::class, 'search'])->name('search');

    //Route user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/trash', [UserController::class, 'trash_show'])->name('users.trash');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force', [UserController::class, 'forceDelete'])->name('users.force');

    // Route categories (no soft delete)
    Route::prefix('/categories')->name('categories.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('', [CategoryController::class, 'store'])->name('store');
        Route::get('/{id}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });


    //Route products (has soft delete)
    Route::prefix('/products')->name('products.')->group(function () {
        Route::get('', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::post('/{id}/restore', [ProductController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force', [ProductController::class, 'forceDelete'])->name('force');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
    });

    //Route stock (no soft delete)
    Route::prefix('/stocks')->name('stocks.')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('index');
        Route::get('/create', [StockController::class, 'create'])->name('create');
        Route::post('/', [StockController::class, 'store'])->name('store');
        Route::get('/{id}', [StockController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [StockController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StockController::class, 'update'])->name('update');
        Route::delete('/{id}', [StockController::class, 'destroy'])->name('destroy');
    });


    //Route order (no soft delete)
    Route::prefix('/order')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'show'])->name('show');
        Route::delete('/{id}', [OrderController::class, 'destroy'])->name('destroy');
        Route::put('/{id}', [OrderController::class, 'updateStatus'])->name('updateStatus');
        // Route::put('/{id}', [OrderController::class, 'update'])->name('update');
    });
});

require __DIR__ . '/auth.php';
