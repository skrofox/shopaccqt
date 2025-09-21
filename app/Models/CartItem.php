<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItem extends Model
{
    //
    protected $table = 'cart_items';
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getTotalCartItemsAttribute()
    {
        return $this->where('user_id', Auth::user()->id)->count();
    }

    public function getTotalPriceAttribute()
    {
        return $this->product->price * $this->quantity;
    }
}
