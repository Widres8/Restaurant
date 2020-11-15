<?php

namespace App\Repository\classes;

use App\Models\User;
use App\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    protected $model     = User::class;
    protected $userModel = User::class;
}