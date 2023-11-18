<?php

declare(strict_types=1);

namespace App;

use App\Models\News;
use App\Models\NewsCollection;
use GuzzleHttp\Client;

class Api
{

    private Client $client;
    private string $api;

    public function __construct()
    {
        $this->api = 'https://newsapi.org/v2/top-headlines?q=';
        $this->client = new Client(); //['verify' => 'C:/CA certificates/cacert.pem',]
    }

    public function fetchNews(
        string $q='us',
        string $country=null,
        string $from=null,
        string $to=null
    ): NewsCollection
    {
        $apiKey = $_ENV['API_KEY'];
        $newsUrl = $this->api . $q .
            '&country=' . $country .
            '&from=' . $from .
            '&to=' . $to .
            '&apiKey=' . $apiKey;

        $response = $this->client->get($newsUrl);
        $newsData = json_decode((string)$response->getBody());
        //dump($weatherData); die;

        $collection = new NewsCollection();

        foreach ($newsData->articles as $news) {
            $collection->add(new News(
                $news->title,
                $news->description,
                $news->url,
                $news->urlToImage
            ));
        }

        return $collection;


        }

}

//Šāds salikums strādā, ja kāds elements ir tukšs, tad to neņem vērā:
//https://newsapi.org/v2/top-headlines?q=trump&country=us&from=2023-10-08&to=2023-11-07&apiKey=bdecca4173c3468eb9b980ffe5e4f162