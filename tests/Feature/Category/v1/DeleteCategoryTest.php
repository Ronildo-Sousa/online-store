<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(fn () => $this->category = Category::factory()->create());

it('should be able to delete a category', function () {
    actingAs(User::factory()->create(['is_admin' => true]))
        ->deleteJson(route('categories.destroy', [
            'category' => $this->category,
        ]))
        ->assertNoContent();

    assertDatabaseMissing('categories', ['id' => $this->category->id]);
});

it('should not be able to non admin user delete a category', function () {
    actingAs(User::factory()->create(['is_admin' => false]))
        ->deleteJson(route('categories.destroy', [
            'category' => $this->category,
        ]))
        ->assertForbidden();

    assertDatabaseHas('categories', ['id' => $this->category->id]);
});

test('category should exists to create be deleted', function () {
    actingAs(User::factory()->create(['is_admin' => false]))
        ->deleteJson(route('categories.destroy', [
            'category' => 0,
        ]))
        ->assertNotFound();
});
