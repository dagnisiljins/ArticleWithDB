<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Api;
use App\Response;
use Carbon\Carbon;
use App\WeatherApi;

class MainController
{
    private Api $api;
    private WeatherApi $weatherApi;

    public function __construct()
    {
        $this->api = new Api();
        $this->weatherApi = new WeatherApi();
    }
    public function search(): Response
    {
        $setToToday = Carbon::now()->format('Y-m-d');

        $q = $_GET['q'] ?? '';
        $country = $_GET['country'] ?? 'lv';
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? $setToToday;

        $countryMappings = [
            'us' => 'USA',
            'au' => 'Australia',
            'gb' => 'United Kingdom',
            'lv' => 'Latvia',
        ];

        $countryToDisplay = $countryMappings[$country];

        $to = Carbon::parse($to)->format('Y-m-d');

        if (!empty($from) && !empty($to)) {
            $fromDate = Carbon::createFromFormat('Y-m-d', $from);
            $toDate = Carbon::createFromFormat('Y-m-d', $to);

            $searchDays = $fromDate->diffInDays(Carbon::now()->format('Y-m-d'));

            if($searchDays > 30) {
                return new Response(
                    'News/index',
                    [
                        'message' => "You can't search articles older then 30 days!"
                    ]
                );
            }
        }

        $news = $this->api->fetchNews($q, $country, $from, $to);

        $weatherData = $this->weatherApi->fetchWeatherFromUrl('Riga');

        return new Response(
            'News/index',
            [
                'message' => 'Top Articles in ' . $countryToDisplay,
                'newsCollection' => $news,
                'weather' => $weatherData
            ]
        );
    }

}