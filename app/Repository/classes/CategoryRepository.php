<?php

namespace App\Repository\classes;

use App\Models\Category;
use App\Repository\BaseRepository;

class CategoryRepository extends BaseRepository
{
    protected $model = Category::class;
}