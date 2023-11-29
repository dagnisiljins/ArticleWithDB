<?php

declare(strict_types=1);

namespace App\Database;

use GuzzleHttp\Client;

class NewsApi
{

    private Client $client;
    private string $api;

    public function __construct()
    {
        $this->api = 'https://newsapi.org/v2/top-headlines?q=';
        $this->client = new Client();
    }

    public function fetchNews(
        string $q = 'us',
        string $country = null,
        string $from = null,
        string $to = null
    ): \stdClass
    {
        $apiKey = $_ENV['API_KEY'];
        $newsUrl = $this->api . $q .
            '&country=' . $country .
            '&from=' . $from .
            '&to=' . $to .
            '&apiKey=' . $apiKey;

        $response = $this->client->get($newsUrl);
        return json_decode((string)$response->getBody());

    }

}