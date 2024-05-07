<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit_per_page', 15);
        // $is_done = $request->query('is_done', 0);

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters(['is_done', 'category', 'title', 'due_date'])
            ->defaultSort('-created_at')
            ->allowedSorts(['title', 'due_date', 'category', 'is_done', 'created_at'])
            ->paginate($limit);
        return new TaskCollection($tasks);
    }

    public function show(Request $request, Task $task)
    {
        if (Auth::id() == $task->created_by) {
            return new TaskResource($task);
        } else {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Auth::user()->tasks()->create($validated);
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update($validated);
        return new TaskResource($task);
    }

    public function destroy(Request $request, Task $task)
    {
        $task->delete();
        return response()->noContent();
    }
}
