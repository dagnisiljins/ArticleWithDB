<?php

declare(strict_types=1);

namespace App\Models;

class CityWeatherData
{

    private string $cityName;
    private string $description;
    private float $temp;
    public function __construct(string $cityName, string $description, float $temp)
    {
        $this->cityName = $cityName;
        $this->description = $description;
        $this->temp = $temp;
    }

    public function getCityName(): string
    {
        return 'Today in ' . $this->cityName;
    }

    public function getDescription(): string
    {
        $descriptionToSymbol = [
            'clear sky' => '☀️',
            'few clouds' => '🌤',
            'scattered clouds' => '🌥',
            'broken clouds' => '☁️',
            'overcast clouds' => '🌦',
            'shower rain' => '🌧',
            'rain' => '🌧',
            'light rain' => '🌧',
            'moderate rain' => '🌧'
        ];

        return $descriptionToSymbol[$this->description] ?? $this->description;
    }

    public function getTemp(): string
    {
        return 'Temperature: ' . round($this->temp) . '°C';
    }

}