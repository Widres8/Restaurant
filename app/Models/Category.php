<?php

namespace App\Models;

use App\Repository\Models\Model;

class Category extends Model
{
    protected $fillable = [
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}