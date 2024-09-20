<?php

namespace App\Services;

use App\Exceptions\User\UserNotFoundException;
use App\Interfaces\Repositories\IUserRepository;
use App\Interfaces\Services\IUserService;
use Illuminate\Database\Eloquent\Collection;

class UserService implements IUserService
{
    public function __construct(protected IUserRepository $userRepository)
    {
    }

    public function search(string $username): Collection|UserNotFoundException
    {
        if ($this->userRepository->findByUsername($username)->isEmpty()) {
            throw UserNotFoundException::invalidCredentials();
        }

        return $this->userRepository->findByUsername($username);
    }
}
