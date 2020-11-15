<?php

namespace App\Models;

use App\Repository\Models\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'quantity', 'price', 'order_id', 'product_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}