<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IFriendshipRepository;
use App\Models\{Friendship};

class FriendshipRepository extends BaseRepository implements IFriendshipRepository
{
    public function __construct()
    {
        parent::__construct(new Friendship());
    }

}
