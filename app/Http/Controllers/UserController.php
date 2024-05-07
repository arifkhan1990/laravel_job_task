<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{

    public function update(UpdateUserRequest $request, User $user, $id)
    {
        $validated = $request->validated();
        if (Auth::id() != $id) {
            return (new ErrorResource([
                'status' => 'Error',
                'message' => 'You are not authorized to update this user',
                'code' => 403,
                'errors' => null
            ]))->response()->setStatusCode(403);
        } else {
            $userData = User::where('id', $id)->first();
            $userData->update($validated);
            return (new SuccessResource([
                'status' => 'Success',
                'message' => 'Successfully logged out',
                'code' => 200,
                'data' => new UserResource($userData)
            ]))->response()->setStatusCode(200);
        }
    }
}
