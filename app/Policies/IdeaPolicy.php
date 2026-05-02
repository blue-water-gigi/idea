<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;

class IdeaPolicy
{
    /**
     * @param  Idea  $idea
     *
     * Validates whatever you can work with concrete idea
     */
    public function workWith(#[CurrentUser] User $user, Idea $idea): bool
    {
        return $idea->user->is($user);
    }
}
