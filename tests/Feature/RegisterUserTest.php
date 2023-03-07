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

//test('user model fields should be required and valid', function () {
//
//});
