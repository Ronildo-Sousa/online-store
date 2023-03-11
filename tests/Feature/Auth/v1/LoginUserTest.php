<?php

use App\Models\User;

use function Pest\Laravel\postJson;


beforeEach(fn () => $this->user = User::factory()->create());

it('should be able to login', function () {
    postJson(route('auth.login'), [
        'email' => $this->user->email,
        'password' => 'password'
    ])
        ->assertOk()
        ->assertJsonStructure(['user', 'token']);
});

it('should not be able to login with wrong credentials', function () {
    postJson(route('auth.login'), [
        'email' => $this->user->email,
        'password' => 'wrong password'
    ])
        ->assertUnauthorized()
        ->assertJsonStructure(['message']);
});

test('email should be required and valid', function () {
    postJson(route('auth.login'), [
        'email' => '',
        'password' => 'some password'
    ])
        ->assertUnprocessable();

    postJson(route('auth.login'), [
        'email' => 'invalid-email',
        'password' => 'some password'
    ])
        ->assertUnprocessable();
});

test('password should be required', function () {
    postJson(route('auth.login'), [
        'email' => 'email@email.com',
        'password' => ''
    ])
        ->assertUnprocessable();
});
