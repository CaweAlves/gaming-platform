<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IUserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    public function findByUsername(string $username): Collection
    {
        return $this->model->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($username) . '%'])->get();
    }
}
