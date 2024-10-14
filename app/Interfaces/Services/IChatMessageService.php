<?php

namespace App\Interfaces\Services;

use App\Models\ChatMessage;

interface IChatMessageService
{
    public function sendMessageToAFriend(int $friendId): ChatMessage;
}
