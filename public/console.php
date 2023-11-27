<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Services\Articles\DeleteArticleService;
use App\Services\Articles\IndexArticleService;
use App\Services\Articles\SearchArticleService;
use App\Services\Articles\ShowArticleService;
use App\Services\Articles\StoreArticleService;

/*
$service = new IndexArticleService();
$articles = $service->execute();
var_dump($articles);
*/

/*
$service = new ShowArticleService();
$article = $service->execute(6);
var_dump($article);
*/

/*
$store = new StoreArticleService();
$store->execute('tests 2', 'tests 2', 'tests 2');
*/
/*
$service = new SearchArticleService();
$articles = $service->execute('test');
var_dump($articles);
*/

$service = new DeleteArticleService();
$service->execute(28);

/*
$store = new StoreArticleService();
$store->execute('Console update', 'test', 'test', 19);
*/