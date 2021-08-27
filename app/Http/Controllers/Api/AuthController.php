<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $input = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token = $user->createToken(time())->plainTextToken;

        return \Response::json([
            'status' => true,
            'message' => "Registered successfully.",
            'data' => compact('user', 'token')
        ]);
    }

    public function login(): JsonResponse
    {
        return \Response::json([]);
    }

    public function logout(): JsonResponse
    {
        return \Response::json([]);
    }
}
