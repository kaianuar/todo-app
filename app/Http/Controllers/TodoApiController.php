<?php

namespace App\Http\Controllers;

use App\Http\Resources\TodoResource;
use App\Http\Requests\UpdateTodoStatusRequest;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Request;

class TodoApiController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 15);

        $todos = $this->todoService->getAllPaginated($page, $perPage); 
        return TodoResource::collection($todos);
    }

    public function update($id, UpdateTodoStatusRequest $request)
    {
        $validatedData = $request->validated();

        $todo = $this->todoService->updateStatus($id, $validatedData['status']);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return new TodoResource($todo);
    }
}
