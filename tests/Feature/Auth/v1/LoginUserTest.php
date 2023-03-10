<?php

use App\Models\User;

use function Pest\Laravel\post;
use function Pest\Laravel\postJson;
use function Pest\Laravel\withoutExceptionHandling;

beforeEach(fn () => $this->user = User::factory()->create());

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
