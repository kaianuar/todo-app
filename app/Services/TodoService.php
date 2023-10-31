<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoService
{
    public function getAllPaginated(int $perPage): LengthAwarePaginator
    {
        return Todo::paginate($perPage);
    }
}