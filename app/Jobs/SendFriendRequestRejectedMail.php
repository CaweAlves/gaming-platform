<?php

namespace App\Jobs;

use App\Mail\FriendRequestRejectedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendFriendRequestRejectedMail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user, public User $rejectedFriend)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(new FriendRequestRejectedMail($this->rejectedFriend));
    }
}
