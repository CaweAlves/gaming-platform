<?php

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};

use function Pest\Laravel\{assertDatabaseCount, postJson};

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

it('should not be possible to register a new user if the email is invalid', function () {
    $name  = $this->faker->name;
    $email = str($this->faker->unique()->email)->replace('.com', '');

    $payload = [
        'name'                  => $name,
        'email'                 => $email,
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];

    $response = postJson('/api/v1/register', $payload);

    $response->assertStatus(422);
    expect($response->json("message"))->toContain("The email field must be a valid email address");
    ;

    assertDatabaseCount('users', 0);
});

it('should not be possible to register a new user if the email is null', function () {
    $name = $this->faker->name;

    $payload = [
        'name'                  => $name,
        'email'                 => '',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];

    $response = postJson('/api/v1/register', $payload);

    $response->assertStatus(422);
    expect($response->json("message"))->toContain("The email field is required.");
    ;

    assertDatabaseCount('users', 0);
});
