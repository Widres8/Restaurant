<?php

namespace App\Models;

use App\Repository\Models\Model;

class Product extends Model
{
    protected $fillable = [
        'description', 'measurenment_unit', 'stock', 'price', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}