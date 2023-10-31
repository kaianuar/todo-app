<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieval of all Todo items in a paginated format.
     */
    public function test_index_paginated()
    {
        Todo::factory(50)->create();

        $response = $this->getJson('/api/v1/todos?page=1&perPage=10');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'status'
                        ]
                    ],
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next'
                    ],
                    'meta' => [
                        'current_page',
                        'from',
                        'last_page',
                        'links',
                        'path',
                        'per_page',
                        'to',
                        'total'
                    ]
                ])
                ->assertJsonCount(10, 'data')
                ->assertJsonPath('meta.total', 50);
    }

    /**
     * Test updating the status of a Todo by ID.
     */
    public function test_update_status()
    {
        $todo = Todo::factory()->create();
        $response = $this->patchJson("/api/v1/todos/{$todo->id}", [
            'status' => 'done'
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'title',
                        'description',
                        'status'
                    ]
                ])
                ->assertJsonPath('data.status', 'done');

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'status' => 'done'
        ]);
    }

    /**
     * Test updating the status of a Todo that doesn't exist.
     */
    public function test_update_status_404()
    {
        $response = $this->patchJson("/api/v1/todos/9999999", [
            'status' => 'done'
        ]);

        $response->assertStatus(404)
                ->assertJson(['error' => 'Todo not found']);
    }

    /**
 * Test updating the status of a Todo with an invalid request.
 */
public function test_update_status_422()
{
    $todo = Todo::factory()->create();

    // Status is missing
    $response = $this->patchJson("/api/v1/todos/{$todo->id}", []);

    $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
}
}
