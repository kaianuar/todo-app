<?php

namespace App\Jobs;

use App\Services\TodoService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTodoStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function handle(TodoService $todoService): void
    {
        $todoService->updateAllStatusesInChunks($this->status);
    }
}
