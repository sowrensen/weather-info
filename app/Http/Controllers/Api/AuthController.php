<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(): JsonResponse
    {
        return \Response::json([]);
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
