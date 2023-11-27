<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use App\Services\Articles\{
    DeleteArticleService,
    IndexArticleService,
    SearchArticleService,
    ShowArticleService,
    StoreArticleService
};
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;
use function DI\create;
use function DI\get;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ArticleRepositoryInterface::class => create(MysqlArticleRepository::class),
    IndexArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    ShowArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
]);
$container = $containerBuilder->build();

$indexService = $container->get(IndexArticleService::class);
$showService = $container->get(ShowArticleService::class);

/*
$articles = $indexService->execute();
var_dump($articles);
*/


$article = $showService->execute(1);
var_dump($article);


/*
$store = new StoreArticleService();
$store->execute('tests 2', 'tests 2', 'tests 2');
*/
/*
$service = new SearchArticleService();
$articles = $service->execute('test');
var_dump($articles);
*/

/*$service = new DeleteArticleService();
$service->execute(28);*/

/*
$store = new StoreArticleService();
$store->execute('Console update', 'test', 'test', 19);
*/