<?php

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, postJson};

uses(TestCase::class)->in('Feature');

it('should be able to login', function () {
    $user = User::factory()->create();

    $response = postJson('/api/v1/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    expect($response->status())->toBe(200);
    expect($response->json())->toHaveKey('token');
    expect($response->json('message'))->toBe('Authorized');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);

});

it('should be able to logout of the application', function () {
    $user = User::factory()->create();

    actingAs($user);

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);

    $response = postJson('/api/v1/logout');

    expect($response->status())->toBe(200);

    expect(auth()->guest())->toBeTrue();
});

it('should be able to register a new user in the application', function () {
    $response = postJson('/api/v1/register', [
        'name'                  => 'Test User',
        'email'                 => 'test@user.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    assertDatabaseHas('users', [
        'name'  => 'Test User',
        'email' => 'test@user',
    ]);

    assertDatabaseCount('users', 1);

    expect(auth()->check())->and(auth()->user())
    ->id->toBe(User::first()->id);

});
