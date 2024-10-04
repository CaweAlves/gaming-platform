<?php

use Illuminate\Foundation\Testing\TestCase;

uses(TestCase::class)->in('Unit');

arch('Friendship is a Model')
    ->expect('App\Models\Friendship')
    ->toBeClass()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toUse('Illuminate\Database\Eloquent\Factories\HasFactory');

arch('FriendshipStatus is a Enum')
    ->expect('App\Enums\FriendshipStatus')
    ->toBeEnum();
