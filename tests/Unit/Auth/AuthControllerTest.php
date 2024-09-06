<?php

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

use function Pest\Laravel\postJson;

uses(TestCase::class);

test('user should be able to generate a valid authentication token', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    expect($token)->toBeString()
        ->not()->toBeEmpty()->toBeValidToken();
});

it('should be able to login', function () {
    $user = User::factory()->create();

    $response = postJson('/api/v1/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    expect($response->status())->toBe(200);
    expect($response->json())->toHaveKey('token');
    expect($response->json())->toHaveKey('message');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->user())->id->toBe($user->id);

});
