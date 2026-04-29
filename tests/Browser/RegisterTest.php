<?php

declare(strict_types=1);

it('register a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email', 'JohnDoe@mail.com')
        ->fill('password', 'password')
        ->click('Create account')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'JohnDoe@mail.com',
    ]);
});
