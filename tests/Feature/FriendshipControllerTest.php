<?php

use App\Models\{Friendship, User};
use Carbon\Carbon;
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};

use function Pest\Laravel\{actingAs, postJson};

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

test('should be able to send friend requests', function () {
    $user   = User::factory()->create();
    $friend = User::factory()->create();

    actingAs($user);

    $response = postJson('/api/v1/friends/requests/' . $friend->id);

    $this->assertDatabaseHas('friendships', [
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        "updated_at"   => Carbon::now()->format('Y-m-d H:i:s'),
        "created_at"   => Carbon::now()->format('Y-m-d H:i:s'),
        'status'       => 'pending',
    ]);

    $response->assertCreated();

    $response->assertJsonCount(4);
    $response->assertJsonIsObject('request');
    $response->assertJsonIsObject('friend');

    expect($response->json('message'))->toContain('Request sending with success.');
    expect($response->json('friend.name'))->toContain($friend->name);
    expect($response->json('status'))->toContain('pending');
});

test('should make sure to inform the user of an error when a request already exists', function () {
    $user   = User::factory()->create();
    $friend = User::factory()->create();

    actingAs($user);

    $response = postJson('/api/v1/friends/requests/' . $friend->id);

    $this->assertDatabaseHas('friendships', [
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        "updated_at"   => Carbon::now()->format('Y-m-d H:i:s'),
        "created_at"   => Carbon::now()->format('Y-m-d H:i:s'),
        'status'       => 'pending',
    ]);

    $response->assertCreated();
    $response = postJson('/api/v1/friends/requests/' . $friend->id);

    $response->assertConflict();
    expect($response->json('message'))->toContain('There is already a pending request for this user.');
});

test('should be able accept a friend request', function () {
    $user   = User::factory()->create();
    $friend = User::factory()->create();

    actingAs($friend);

    $request = Friendship::create([
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        'status'       => 'pending',
    ]);

    $requestPayload = [
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        "updated_at"   => Carbon::now()->format('Y-m-d H:i:s'),
        "created_at"   => Carbon::now()->format('Y-m-d H:i:s'),
    ];

    $this->assertDatabaseHas('friendships', array_merge($requestPayload, ['status' => 'pending']));

    $reponse = postJson(sprintf('api/v1/friends/requests/accept/%s', $request->id));

    $this->assertDatabaseHas('friendships', array_merge($requestPayload, ['status' => 'accepted']));

    $reponse->assertOk();
    expect($reponse->json('message'))->toContain('Friend request accepted successfully.');
    expect($reponse->json('status'))->toContain('accepted');
});
