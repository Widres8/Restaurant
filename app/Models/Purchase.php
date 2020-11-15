<?php

namespace App\Models;

use App\Repository\Models\Model;

class Purchase extends Model
{
    protected $fillable = [
        'description', 'price', 'comments',
    ];
}