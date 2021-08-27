<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

    public function login(Request $request): JsonResponse
    {
        $input = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::where('email', $input['email'])->first();

        if (! \Hash::check($input['password'], $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'password' => "Password doesn't match."
            ]);
        }

        return \Response::json([
            'status' => true,
            'message' => 'Successfully logged in.',
            'data' => [
                'token' => $user->createToken(time())->plainTextToken
            ]
        ]);
    }

    public function logout(): JsonResponse
    {
        return \Response::json([]);
    }
}
