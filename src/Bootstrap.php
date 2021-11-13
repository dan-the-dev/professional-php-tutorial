<?php
declare(strict_types=1);

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tracy\Debugger;
use function FastRoute\simpleDispatcher;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR . '/vendor/autoload.php';

Debugger::enable();

$request = Request::createFromGlobals();

$dispatcher = simpleDispatcher(
    function (RouteCollector $routeCollector) {
        $routes = include(ROOT_DIR . '/src/Routes.php');
        foreach ($routes as $route){
            $routeCollector->addRoute(...$route);
        }
    }
);

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    $request->getPathInfo(),
);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        $response = new Response('Not found', 404);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $response = new Response('Method not allowed', 405);
        break;
    case Dispatcher::FOUND:
        [$controllerName, $method] = explode('#', $routeInfo[1]);
        $vars = $routeInfo[2];
        $controller = new $controllerName;
        $response = $controller->$method($request, $vars);
        break;
}


if (!$response instanceof Response) {
    throw new Exception(
        'Controller methods must return a Response object'
    );
}

$response->prepare($request);
$response->send();
