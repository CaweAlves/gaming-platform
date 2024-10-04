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
            throw new UserNotFoundException();
        }

        return $this->userRepository->findByUsername($username);
    }

    public function getFriends(int $user): Collection|UserNotFoundException
    {
        if (!$this->userRepository->find($user)) {
            throw new UserNotFoundException();
        }

        return $this->userRepository->findFriendsByUser($user);
    }
}
