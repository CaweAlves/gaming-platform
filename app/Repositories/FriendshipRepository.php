<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IFriendshipRepository;
use App\Models\{Friendship};
use Illuminate\Database\Eloquent\Collection;

class FriendshipRepository extends BaseRepository implements IFriendshipRepository
{
    public function __construct()
    {
        parent::__construct(new Friendship());
    }

    public function pendingRequests(int $user): Collection
    {
        return $this->model
            ->whereAny(['requester_id', 'recipient_id'], '=', $user)
            ->get();
    }

}
