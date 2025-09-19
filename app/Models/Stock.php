<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    protected $table = 'stocks';
    protected $fillable = [
        'product_id',
        'on_hand',
        'min_stock',
        'max_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
