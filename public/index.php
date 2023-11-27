<?php

session_start();

use App\Controllers\MainController;
use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;
use App\Response\RedirectResponse;
use App\Response\ViewResponse;
use App\Router\Router;
use App\Services\Articles\DeleteArticleService;
use App\Services\Articles\IndexArticleService;
use App\Services\Articles\SearchArticleService;
use App\Services\Articles\ShowArticleService;
use App\Services\Articles\StoreArticleService;
use App\Services\Articles\UpdateArticleService;
use Carbon\Carbon;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
//////
use DI\ContainerBuilder;
use function DI\create;
use function DI\get;


require_once __DIR__ . '/../vendor/autoload.php';



function addNotificationsToTwig(Environment $twig): void {
    if (isset($_SESSION['notifications'])) {
        $twig->addGlobal('notifications', $_SESSION['notifications']);
        unset($_SESSION['notifications']);
    }
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$loader = new FilesystemLoader(__DIR__ . '/../Views/');
$twig = new Environment($loader);

$currentTime = Carbon::now('Europe/Riga')->format('Y-m-d');
$twig->addGlobal('globalTime', $currentTime);


$twig->addExtension(new DebugExtension());

$routeInfo = Router::dispatch();

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    ArticleRepositoryInterface::class => create(MysqlArticleRepository::class),
    IndexArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    ShowArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    StoreArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    SearchArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    UpdateArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    DeleteArticleService::class => create()->constructor(get(ArticleRepositoryInterface::class)),
    MainController::class => create()->constructor(
        get(IndexArticleService::class),
        get(ShowArticleService::class),
        get(StoreArticleService::class),
        get(SearchArticleService::class),
        get(UpdateArticleService::class),
        get(DeleteArticleService::class),
    ),
]);

$container = $containerBuilder->build();

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $template = $twig->load('Error/notFound.twig');
        echo $template->render();
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        [$className, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        //$response = (new $className())->{$method}($vars);
        $controller = $container->get($className);
        $response = $controller->{$method}($vars);


        addNotificationsToTwig($twig);

        switch (true)
        {
            case $response instanceof ViewResponse:
                echo $twig->render($response->getViewName() . '.twig', $response->getData());
                break;
            case $response instanceof RedirectResponse:
                $response->send();
                break;
            default:
                echo 'View default';
                break;
        }

        break;
}