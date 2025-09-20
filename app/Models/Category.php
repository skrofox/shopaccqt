<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //

    protected $fillable = [
        'name',
        'slug',
        'image',
        'is_active'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTotalProductsAttribute()
    {
        return $this->products()->where('is_active', 1)->count();
    }
}
