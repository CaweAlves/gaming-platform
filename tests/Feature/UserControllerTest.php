<?php

use App\Models\{Friendship, User};
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\{actingAs, getJson};

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

test('should be able find user by username', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = getJson('/api/v1/users/search?username=' . $user->name);

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json->has('users.0.name')->whereContains('users.0.name', $user->name));
});

test('should make sure to inform the user of an error when a user is not found', function () {
    $user = User::factory()->create(['name' => 'validUser']);
    actingAs($user);

    $response = getJson(sprintf('/api/v1/users/search?username=%s', 'nonExistingUsers'));

    $response->assertStatus(404)
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json->has('message')->whereContains('message', 'No users were found.'));
});

test("should be able to list a user's friends", function () {
    $user   = User::factory()->create();
    $friend = User::factory()->create();

    actingAs($user);

    $request = Friendship::create([
        'requester_id' => $user->id,
        'recipient_id' => $friend->id,
        'status'       => 'accepted',
    ]);

    $reponse = getJson('api/v1/users/friends');

    $reponse->assertOk();
    expect($reponse->json('friends.0'))
        ->toContain($friend->id);
});
