<?php

use App\Jobs\SendWelcomeMail;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\{RefreshDatabase, TestCase};
use Illuminate\Support\Facades\Queue;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, postJson};

uses(TestCase::class, RefreshDatabase::class, WithFaker::class)->in('Feature');

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

it('should make sure to inform the user an error when email and password doesnt work', function () {
    $response = postJson('/api/v1/login', [
        'email'    => 'invalid@user.com',
        'password' => 'password',
    ]);

    expect($response->status())->toBe(401);
    expect($response->json('message'))->toBe('Invalid credentials');
    expect(auth()->check())->toBeFalse();
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
    $name  = $this->faker->name;
    $email = $this->faker->unique()->safeEmail;

    $payload = [
        'name'                  => $name,
        'email'                 => $email,
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];

    postJson('/api/v1/register', $payload)->assertStatus(201);

    assertDatabaseHas('users', [
        'name'  => $name,
        'email' => $email,
    ]);

    assertDatabaseCount('users', 1);

    expect(auth()->check())->and(auth()->user())
        ->id->toBe(User::first()->id);

});

test('should send a email to new user', function () {
    Queue::fake();

    $payload = [
        'name'                  => $this->faker->name,
        'email'                 => $this->faker->unique()->safeEmail,
        'password'              => 'password',
        'password_confirmation' => 'password',
    ];

    $this->postJson('api/v1/register', $payload)
        ->assertStatus(201);

    Queue::assertPushed(SendWelcomeMail::class, function ($job) use ($payload) {
        return $job->user->email === $payload['email'];
    });
});
