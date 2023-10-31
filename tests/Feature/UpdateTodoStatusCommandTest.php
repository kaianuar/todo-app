<?php

namespace Tests\Feature;

use App\Jobs\UpdateTodoStatusJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UpdateTodoStatusCommandTest extends TestCase
{
    public function test_it_queues_a_job_to_update_all_statuses(): void
    {
        Queue::fake();

        $this->artisan('todo:update-all-to-done')
            ->expectsOutput('All to-do statuses are being updated in the background.');

        Queue::assertPushed(UpdateTodoStatusJob::class);
    }
}
