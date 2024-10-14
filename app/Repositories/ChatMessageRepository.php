<?php

namespace App\Repositories;

use App\Interfaces\Repositories\IChatMessageRepository;
use App\Models\ChatMessage;

class ChatMessageRepository extends BaseRepository implements IChatMessageRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        parent::__construct(new ChatMessage());
    }
}
