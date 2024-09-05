<?php

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

uses(TestCase::class);

test('user should be able to generate a valid authentication token', function () {
    $user = User::factory()->create();

    $token = $user->createToken('auth_token')->plainTextToken;

    expect($token)->toBeString()
        ->not()->toBeEmpty()->toBeValidToken();
});
