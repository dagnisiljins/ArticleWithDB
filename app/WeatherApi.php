<?php

declare(strict_types=1);

namespace App;

use App\Models\CityWeatherData;
use GuzzleHttp\Client;

class WeatherApi
{
    private Client $client;
    private string $weatherApi;

    public function __construct()
    {
        $this->weatherApi = 'https://api.openweathermap.org/data/2.5/weather?q=';
        $this->client = new Client(); //['verify' => 'C:/CA certificates/cacert.pem',]
    }

    public function fetchWeatherFromUrl(string $city): CityWeatherData
    {
        $apiKey = $_ENV['API_KEY_TWO'];
        $weatherUrl = $this->weatherApi . $city . '&appid=' . $apiKey . '&units=metric';

        $response = $this->client->get($weatherUrl);
        $weatherData = json_decode((string)$response->getBody());

        return new CityWeatherData(
            $weatherData->name,
            $weatherData->weather[0]->description,
            $weatherData->main->temp
        );
    }
}