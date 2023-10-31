<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $todoService;

    public function setUp(): void
    {
        parent::setUp();
        $this->todoService = app(TodoService::class);
    }


    public function test_it_can_fetch_paginated_todos(): void
    {
        Todo::factory()->count(50)->create();

        $todos = $this->todoService->getAllPaginated(10);

        $this->assertCount(10, $todos->items());
        $this->assertEquals(50, $todos->total());
    }

    public function test_it_can_update_a_todo_status_to_done(): void
    {
        $todo = Todo::factory()->create(['status' => 'pending']);
        $this->todoService->updateStatus($todo->id, 'done');

        $this->assertEquals('done', $todo->fresh()->status);
    }
}
