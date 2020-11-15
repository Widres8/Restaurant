<?php

namespace App\Repository\classes;

use App\Models\Product;
use App\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected $model = Product::class;
}