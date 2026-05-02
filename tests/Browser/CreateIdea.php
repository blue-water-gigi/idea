<?php

declare(strict_types=1);

use App\Models\User;

it('creates a new idea', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('idea.store'), [
        'title' => 'Test title',
        'status' => 'completed',
        'description' => 'MY DESCRIPTION BRO',
        'links' => ['https://laravel.com', 'https://anotherlink.com'],
    ]);

    $response->assertRedirect(route('idea.index'));

    $idea = $user->fresh()->ideas()->first();

    expect($idea)
        ->not->toBeNull()
        ->title->toBe('Test title')
        ->status->value->toBe('completed')
        ->description->toBe('MY DESCRIPTION BRO')
        ->links->toArray()->toBe(['https://laravel.com', 'https://anotherlink.com']);
});
