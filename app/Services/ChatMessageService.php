<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Interfaces\Repositories\IChatMessageRepository;
use App\Interfaces\Services\IChatMessageService;
use App\Models\ChatMessage;

class ChatMessageService implements IChatMessageService
{
    /**
     * Create a new class instance.
     */
    public function __construct(public IChatMessageRepository $chatRepository)
    {
        //
    }

    public function sendMessageToAFriend(int $friendId): ChatMessage
    {
        $message = $this->chatRepository->create([
            'sender_id'   => auth()->user()->getAuthIdentifier(),
            'receiver_id' => $friendId,
            'text'        => request()->input('message'),
        ]);

        broadcast(new MessageSent($message));

        return $message;
    }

}
