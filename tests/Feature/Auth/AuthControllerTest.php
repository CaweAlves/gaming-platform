<?php

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

use function Pest\Laravel\postJson;

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
