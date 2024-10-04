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

    public function findFriendsByUser(int $userId): Collection
    {
        return $this->model->newQuery()
        ->whereIn('id', function ($query) use ($userId) {
            $query->select('requester_id')
                ->from('friendships')
                ->where('recipient_id', $userId)
                ->where('status', 'accepted')
                ->union(
                    $query->newQuery()
                        ->select('recipient_id')
                        ->from('friendships')
                        ->where('requester_id', $userId)
                        ->where('status', 'accepted')
                );
        })
        ->get();
    }
}
