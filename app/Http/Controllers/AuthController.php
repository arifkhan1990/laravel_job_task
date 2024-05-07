<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\SuccessResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        $credentials = $request->only('email', 'password');
        $userFind = User::where('email', $credentials['email'])->first();

        if (!$userFind) {
            return (new ErrorResource([
                'status' => 'Error',
                'message' => 'User not Found!',
                'code' => 404,
                'errors' => null
            ]))->response()->setStatusCode(404);
        }

        $token = Auth::attempt($validated);
        if (!$token) {
            return (new ErrorResource([
                'status' => 'Error',
                'message' => 'Login failed, Please check your email and password!',
                'code' => 401,
                'errors' => null
            ]))->response()->setStatusCode(401);
        }

        $user = Auth::user();
        return (new SuccessResource([
            'status' => 'Success',
            'message' => 'User login successfully',
            'code' => 200,
            'data' => [
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]
        ]))->response()->setStatusCode(200);
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $token = Auth::login($user);
        return (new SuccessResource([
            'status' => 'Success',
            'message' => 'User created successfully',
            'code' => 201,
            'data' => [
                'user' => $user
            ]
        ]))->response()->setStatusCode(201);
    }

    public function logout()
    {
        Auth::logout();
        return (new SuccessResource([
            'status' => 'Success',
            'message' => 'Successfully logged out',
            'code' => 200,
            'data' => null
        ]))->response()->setStatusCode(200);
    }

    public function refresh()
    {
        return (new SuccessResource([
            'status' => 'Success',
            'message' => 'Token refresh successfully',
            'code' => 200,
            'data' => [
                'authorisation' => [
                    'token' => Auth::refresh(),
                    'type' => 'bearer',
                ]
            ]
        ]))->response()->setStatusCode(200);
    }
}
