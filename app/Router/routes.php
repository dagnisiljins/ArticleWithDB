<?php

return [
    ['GET', '/', ['App\Controllers\MainController', 'search']],
    ['GET', '/search', ['App\Controllers\MainController', 'search']],
    ['GET', '/weather', ['App\Controllers\WeatherController', 'getWeatherData']]
];