<?php

namespace Tests\Unit;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_a_todo(): void
    {
        $todo = Todo::create([
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('todos', [
            'title' => $todo->title,
            'description' => $todo->description,
            'status' => 'pending'
        ]);
    }

    public function test_can_update_a_todo(): void
    {
        $todo = Todo::create([
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ]);

        $todo->update([
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'done'
        ]);

        $this->assertDatabaseHas('todos', [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'done'
        ]);
    }

    public function test_can_delete_a_todo() : void
    {
        $todo = Todo::create([
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => 'pending'
        ]);

        $todo->delete();

        $this->assertDatabaseMissing('todos', [
            'title' => 'Sample Title',
            'description' => 'Sample Description',
            'status' => 'pending'
        ]);
    }
}
