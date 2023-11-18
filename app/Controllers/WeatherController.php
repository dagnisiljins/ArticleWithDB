<?php

declare(strict_types=1);

namespace App\Controllers;

use App\WeatherApi;
use App\Response;

class WeatherController
{
    private WeatherApi $api;
    private string $defaultCity;
    private string $searchedCity;
    public function __construct()
    {
        $this->api = new WeatherApi();
        $this->defaultCity = 'Riga';
        $this->searchedCity = $_GET['s'] ?? '';
    }

    public function getWeatherData(): Response
    {
        $defaultWeather = $this->api->fetchWeatherFromUrl($this->defaultCity);

        $searchedCity = $_GET['s'] ?? '';
        $searchedWeather = null;

        if (!empty($searchedCity)) {
            $searchedWeather = $this->api->fetchWeatherFromUrl($searchedCity);
        }

        return new Response( 'weather/index',
            [
            'defaultWeather' => $defaultWeather,
            'searchedWeather' => $searchedWeather,
        ]);
    }
}