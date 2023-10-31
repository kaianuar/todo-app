<?php

namespace Tests\Unit;

use App\Jobs\UpdateTodoStatusJob;
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

        $page = 2;
        $perPage = 10;
        $todos = $this->todoService->getAllPaginated($page, $perPage);
    
        $this->assertCount(10, $todos->items()); // 10 items per page
        $this->assertEquals(2, $todos->currentPage()); // We are on the second page
        $this->assertEquals(50, $todos->total()); // Total of 50 Todo items
    }

    public function test_it_can_update_a_todo_status_to_done(): void
    {
        $todo = Todo::factory()->create(['status' => 'pending']);
        $this->todoService->updateStatus($todo->id, 'done');

        $this->assertEquals('done', $todo->fresh()->status);
    }

    public function test_it_can_update_a_todo_status_to_pending(): void
    {
        $todo = Todo::factory()->create(['status' => 'done']);
        $this->todoService->updateStatus($todo->id, 'pending');

        $this->assertEquals('pending', $todo->fresh()->status);
    }

    public function test_it_can_update_status_of_all_todos(): void
    {
        Todo::factory()->count(50)->create(['status' => 'pending']);
        Todo::factory()->count(50)->create(['status' => 'done']);

        $this->assertDatabaseCount('todos', 100);
        $this->assertCount(50, Todo::where('status', 'pending')->get());

        $todoService = new TodoService();
        $todoService->updateAllStatusesInChunks('done');
        $this->assertCount(0, Todo::where('status', 'pending')->get());
        $this->assertCount(100, Todo::where('status', 'done')->get());

        $todoService->updateAllStatusesInChunks('pending');
        $this->assertCount(100, Todo::where('status', 'pending')->get());
        $this->assertCount(0, Todo::where('status', 'done')->get());
    }   
}
