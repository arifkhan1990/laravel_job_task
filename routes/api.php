<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Resources\SuccessResource;
use App\Mail\TaskReminderMail;
use App\Mail\TestEmail;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return (new SuccessResource([
        'status' => 'Success',
        'message' => 'User Profiole Information',
        'code' => 200,
        'data' => [
            'user' => $request->user(),
        ]
    ]))->response()->setStatusCode(200);
});

Route::middleware(['auth:api', 'throttle:10,1'])->group(function () {
    Route::put('/user/{id}', [UserController::class, 'update']);
});

Route::middleware(['auth:api', 'throttle:10,1'])->group(function () {
    Route::apiResource('tasks', TaskController::class);
});


// Test the mail sending
Route::get('/send-test-email', function () {
    $task = Task::where('created_by', Auth::id())->first();
    // Check if a Task exists
    if ($task) {
        Mail::to('send_mail.example@gmail.com')->send(new TaskReminderMail($task));
        return response()->json(['message' => 'Test email sent successfully']);
    } else {
        return response()->json(['message' => 'No Task found.'], 404);
    }
});
