<?php

declare(strict_types=1);

use App\Models\User;

it('creates a new idea', function () {
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Test title')
        ->click('@status-button-completed')
        ->fill('description', 'MY DESCRIPTION BRO')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://anotherlink.com')
        ->click('@submit-new-link-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Test title',
        'status' => 'completed',
        'description' => 'MY DESCRIPTION BRO',
        'links' => ['https://laravel.com', 'https://anotherlink.com'],
    ]);
});
