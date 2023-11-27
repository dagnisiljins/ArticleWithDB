<?php

session_start();

use App\Repositories\ArticleRepositoryInterface;
use App\Repositories\MysqlArticleRepository;
use App\Response\RedirectResponse;
use App\Response\ViewResponse;
use App\Router\Router;
use Carbon\Carbon;
use Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;


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

        $response = (new $className())->{$method}($vars);


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