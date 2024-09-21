<?php

namespace App\Jobs;

use App\Mail\NewFriendRequestMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewFriendRequestMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $likelyFriend)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->likelyFriend->email)->send(new NewFriendRequestMail($this->likelyFriend));
    }
}
