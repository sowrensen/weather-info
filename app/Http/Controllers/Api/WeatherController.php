<?php

namespace App\Http\Controllers\Api;

use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __invoke(Request $request, WeatherService $service): JsonResponse
    {
        $request->validate([
            'location' => 'required|string'
        ]);

        try {
            $response = $service->getWeather($request->get('location'));

            if (! $response['success']) {
                throw new \Exception($response['error']['info'] ?? "Invalid request");
            }

            $payload = [
                'location' => $response['location'] ?? null,
                'current_weather' => $response['current'] ?? null
            ];

            return \Response::json([
                'status' => true,
                'message' => 'Success',
                'data' => $payload
            ]);
        } catch (\Exception $exception) {
            return \Response::json([
                'status' => false,
                'message' => $exception->getMessage(),
                'data' => null
            ]);
        }
    }
}
