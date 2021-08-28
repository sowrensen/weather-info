<?php

namespace App\Services;

class WeatherService
{
    private string $endpoint;

    public function __construct()
    {
        $this->endpoint = 'http://api.weatherstack.com/current?access_key='
            .config('services.weather_stack.key').'&query=';
    }

    public function getWeather(string $location): array
    {
        return \Http::get($this->endpoint.$location)->json();
    }
}
