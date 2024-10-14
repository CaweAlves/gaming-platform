<?php
use App\Models\{Friendship, User};
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};

use function Pest\Laravel\{actingAs, postJson};

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

test('should be able to send a message to a friend', function () {
    $user   = User::factory()->create();
    $friend = User::factory()->create();

    Friendship::create([
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        'status'       => 'accepted',
    ]);

    actingAs($user);
    $response = postJson(sprintf('/api/v1/chat/messages/%s', $friend->id), ['message' => '123...testing']);

    $response->assertStatus(201);
});
