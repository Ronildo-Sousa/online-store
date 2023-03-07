<?php

use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(fn () => $this->user = User::factory()->make());

test('it should be able to register a default user', function () {
    postJson(route('auth.register'), [
        'document' => $this->user->document,
        'first_name' => $this->user->first_name,
        'last_name' => $this->user->last_name,
        'email' => $this->user->email,
        'password' => 'password'
    ])
        ->assertCreated()
        ->assertJsonStructure(['user', 'token']);

    assertDatabaseHas('users', [
        'document' => $this->user->document,
        'email' => $this->user->email
    ]);
});

//test('it should be able to register an admin user', function () {
//
//});

test('should not be able to register with empty fields', function () {
    postJson(route('auth.register'), [
        'document' => '',
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'password' => ''
    ])
        ->assertUnprocessable();
});

test('should not be able to register with a document or email that has been taken', function () {
    $user2 = User::factory()->create();
    postJson(route('auth.register'), [
        'document' => $user2->document,
        'first_name' => $this->user->first_name,
        'last_name' => $this->user->last_name,
        'email' => $user2->email,
        'password' => 'password'
    ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['document', 'email']);
});
