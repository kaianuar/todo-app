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
                 ->assertJsonCount(10, 'data')
                 ->assertJsonPath('meta.total', 50);
    }
}
