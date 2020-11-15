<?php

namespace App\Models;

use App\Repository\Models\Model;

class Order extends Model
{
    protected $fillable = [
        'bill_number', 'total',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}