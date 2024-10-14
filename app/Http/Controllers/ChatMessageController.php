<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\IChatMessageService;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function __construct(public IChatMessageService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function send(Request $request, $friend)
    {
        return $this->chatService->sendMessageToAFriend($friend);
    }
}
