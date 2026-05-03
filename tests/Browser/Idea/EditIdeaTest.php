<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\User;

it('shows the initial input state', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show',$idea))
        ->click('@edit-idea-button')
        ->assertValue('title',$idea->title)
        ->assertValue('description',$idea->description)
        ->assertValue('status',$idea->status->value);
});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    $originalFirstLink = $idea->links[0];

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'Updated title')
        ->click('@status-button-completed')
        ->fill('description', 'MY DESCRIPTION BRO')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a thing')
        ->click('@submit-new-step-button')
        ->click('@upd-or-crt-button')
        ->assertPathIs(route('idea.show', $idea, false));

        $idea->refresh();

        expect($idea)->toMatchArray([
        'title' => 'Updated title',
        'status' => 'completed',
        'description' => 'MY DESCRIPTION BRO',
        'links' => [$originalFirstLink, 'https://laravel.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
