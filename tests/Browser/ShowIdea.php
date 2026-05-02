<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\User;

it('requires autentification', function () {
    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea))->assertRedirectToRoute('login');
});

it('requires autorization', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea))->assertForbidden();
});
