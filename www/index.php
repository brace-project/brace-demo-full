<?php
namespace App;


use Brace\Core\Base\JsonReturnFormatter;
use Brace\Core\Base\NotFoundMiddleware;
use Brace\Core\BraceApp;
use Brace\Mod\Request\Zend\BraceRequestZendModule;
use Brace\Router\RouterDispatchMiddleware;
use Brace\Router\RouterEvalMiddleware;
use Brace\Router\RouterModule;
use Brace\Router\Type\Route;
use Laminas\Diactoros\Response\JsonResponse;

require __DIR__ . "/../app/bootstrap.php";

$app = new BraceApp();

$app->addModule(new BraceRequestZendModule());
$app->addModule(new RouterModule());

$app->setPipe([
    new RouterEvalMiddleware(),
    new RouterDispatchMiddleware(new JsonReturnFormatter($app)),
    new NotFoundMiddleware()
]);


$app->router->onGet("/", function (Route $route) {
    return new JsonResponse(["Hello", "World", $route->requestPath]);
});

$app->run();
