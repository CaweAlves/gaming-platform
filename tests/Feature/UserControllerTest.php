<?php

use App\Models\User;
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
