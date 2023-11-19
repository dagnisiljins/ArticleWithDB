<?php

session_start();

use App\Response;
use App\Router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extension\DebugExtension;
use Dotenv\Dotenv;
use Carbon\Carbon;

require_once __DIR__ . '/../vendor/autoload.php';

//$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
//$dotenv->load();

$loader = new FilesystemLoader(__DIR__ . '/../app/Views/');
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
        function addNotificationsToTwig(Environment $twig): void {
            if (isset($_SESSION['notifications'])) {
                $twig->addGlobal('notifications', $_SESSION['notifications']);
                unset($_SESSION['notifications']);
            }
        }
        addNotificationsToTwig($twig);

        /** @var Response $response */
        echo $twig->render($response->getViewName() . '.twig', $response->getData());


        break;
}