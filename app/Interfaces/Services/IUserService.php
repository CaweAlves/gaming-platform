<?php

namespace App\Interfaces\Services;

use App\Exceptions\User\UserNotFoundException;
use Illuminate\Database\Eloquent\Collection;

interface IUserService
{
    public function search(string $username): Collection|UserNotFoundException;
    public function getFriends(int $user): Collection|UserNotFoundException;
}
