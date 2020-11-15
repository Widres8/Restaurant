<?php

namespace App\Repository\classes;

use App\Models\Purchase;
use App\Repository\BaseRepository;

class PurchaseRepository extends BaseRepository
{
    protected $model = Purchase::class;
}