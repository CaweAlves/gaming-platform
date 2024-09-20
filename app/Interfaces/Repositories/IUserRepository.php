<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface IUserRepository
{
    public function findByUsername(string $username): Collection;
}
