<?php

use App\Models\Idea;
use App\Models\User;

test('It belongs to a user', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test('It can have steps', function () {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => fake()->sentence(),
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});
