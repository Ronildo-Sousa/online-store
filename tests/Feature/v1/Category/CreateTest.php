<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;

beforeEach(fn () => $this->user = User::factory()->create(['is_admin' => true]));

it('should create a new category', function () {
    actingAs($this->user)
        ->postJson(route('categories.store'), [
            'name' => 'category name',
        ])
        ->assertCreated();

    assertDatabaseHas('categories', ['name' => 'category name']);
});

// test('only admin user can create a new category', function () {
// });

// test("category name should be required", function () {
// });

// test("category name should be unique in database", function () {
// });
