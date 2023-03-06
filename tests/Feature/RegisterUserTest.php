<?php

use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(fn() => $user = User::factory()->create());

test('it should be able to register a default user', function () {
    dd($this->user);
    postJson(route('auth.register'), [
        'document' => fake()->numerify("###########"),
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'email' => fake()->email(),
        'password' => 'password'
    ])
        ->assertCreated()
        ->assertJsonStructure(['user', 'token']);

    assertDatabaseHas();
});

//test('it should be able to register an admin user', function () {
//
//});

//test('user model fields should be required and valid', function () {
//
//});
