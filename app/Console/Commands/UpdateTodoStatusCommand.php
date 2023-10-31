<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTodoStatusJob;
use App\Services\TodoService;
use Illuminate\Console\Command;

class UpdateTodoStatusCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'todo:update-all-to-done';

    /**
     * @var string
     */
    protected $description = 'Update the status of all to-do items from "pending" to "done"';

    public function __construct(TodoService $todoService)
    {
        parent::__construct();
        $this->todoService = $todoService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UpdateTodoStatusJob::dispatch('done');

        $this->info('All to-do statuses are being updated in the background.');
    }
}
