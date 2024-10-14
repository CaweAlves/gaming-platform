<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    public function send(Request $request, $friend)
    {
        $message = ChatMessage::create([
            'sender_id'   => auth()->user()->getAuthIdentifier(),
            'receiver_id' => $friend,
            'text'        => request()->input('message'),
        ]);
        broadcast(new MessageSent($message));

        return $message;
    }
}
