<?php

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;

use function Pest\Laravel\{postJson};

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

it('should not be possible to log in to a user if the email is not registered', function () {
    $user = User::factory()->create();

    $response = postJson('/api/v1/login', [
        'email'    => 'thisemailnotexists@notexists.com',
        'password' => 'password',
    ]);

    expect($response->status())->toBe(422);

    $response->assertStatus(422);
    expect($response->json("message"))->toContain("Invalid credentials.");
});

it('should not be possible to log in to a user if the password is is incorrect', function () {
    $randomPassword = Hash::make(Random::generate());
    $user           = User::factory()->create(['password' => $randomPassword]);

    $response = postJson('/api/v1/login', [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $response->assertStatus(status: 401);
    expect($response->json("message"))->toContain("Invalid credentials.");
});
