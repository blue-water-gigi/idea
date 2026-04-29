<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('logs in a user', function () {
    $user = User::factory()->create([
        'password' => 'password',
    ]);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('logs out a user', function () {
    $user = User::factory()->create();

    Auth::login($user);

    visit('/')
        ->click('Log out')
        ->assertPathIs('/');

    $this->assertGuest();
});
