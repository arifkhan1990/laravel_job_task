<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit_per_page', 15);
            $tasks = QueryBuilder::for(Task::class)
                ->allowedFilters(['is_done', 'category', 'title', 'due_date'])
                ->defaultSort('-created_at')
                ->allowedSorts(['title', 'due_date', 'category', 'is_done', 'created_at'])
                ->withoutGlobalScope('creator')
                ->paginate($limit);

            return response()->json(new SuccessResource([
                'status' => 'Success',
                'message' => 'Tasks fetched successfully.',
                'code' => 200,
                'data' => new TaskCollection($tasks)
            ]), 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return error response
            return response()->json(new ErrorResource([
                'message' => 'Failed to fetch tasks.',
                'code' => $e->getCode(),
                'errors' => $e->getMessage()
            ]), 500);
        }
    }

    public function show(Request $request, Task $task): JsonResponse
    {
        try {
            return response()->json(new SuccessResource([
                'status' => 'Success',
                'message' => 'Task fetched successfully.',
                'code' => 200,
                'data' => new TaskResource($task)
            ]), 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return error response
            return response()->json(new ErrorResource([
                'message' => 'Failed to fetch task details.',
                'code' => $e->getCode(),
                'errors' => $e->getMessage()
            ]), 500);
        }
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $task = Auth::user()->tasks()->create($validated);

            return response()->json(new SuccessResource([
                'status' => 'Success',
                'message' => 'Task created successfully.',
                'code' => 201,
                'data' => new TaskResource($task)
            ]), 201);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return error response
            return response()->json(new ErrorResource([
                'message' => 'Failed to create task.',
                'code' => $e->getCode(),
                'errors' => $e->getMessage()
            ]), 500);
        }
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            $validated = $request->validated();
            $task->update($validated);

            return response()->json(new SuccessResource([
                'status' => 'Success',
                'message' => 'Task updated successfully.',
                'code' => 200,
                'data' => new TaskResource($task)
            ]), 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return error response
            return response()->json(new ErrorResource([
                'message' => 'Failed to update task.',
                'code' => $e->getCode(),
                'errors' => $e->getMessage()
            ]), 500);
        }
    }

    public function destroy(Request $request, Task $task): JsonResponse
    {
        try {
            $task->delete();

            return response()->json(new SuccessResource([
                'status' => 'Success',
                'code' => 200,
                'message' => 'Task deleted successfully.'
            ]), 200);
        } catch (\Exception $e) {
            // Log the exception
            Log::error($e);

            // Return error response
            return response()->json(new ErrorResource([
                'message' => 'Failed to delete task.',
                'code' => $e->getCode(),
                'errors' => $e->getMessage()
            ]), 500);
        }
    }
}
