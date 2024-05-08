
<?php

use App\Controllers\CalcController;
use App\Controllers\ErrorController;
use App\Controllers\UserController;
use App\Core\Web\Exceptions\RouteNotFoundException;

$container = require_once __DIR__ . '/../src/bootstrap.php';

$uri = $_SERVER['REQUEST_URI'];
$path = substr($uri, 1);
$pathParts = explode('/', $path);
function getRoute(string $uri): array
{
    return match ($uri) {
        'user' => [UserController::class => 'getInfo'],
        'phones' => [UserController::class => 'addPhone'],
        'user/activate' => [UserController::class => 'activate'],
        'users' => [UserController::class => 'getAll'],
        'users/active' => [UserController::class => 'getAllActive'],
        'calc' => [CalcController::class => 'action'],
        default => throw new RouteNotFoundException("Route $uri is not found")
    };
}

try {

    try {
        $actionInfo = getRoute($path);
    } catch (RouteNotFoundException) {
        $actionInfo = getRoute(array_shift($pathParts));
    }
    $class = array_key_first($actionInfo);
    $controller = $container->get($class);
    $method = current($actionInfo);

    echo call_user_func_array([$controller, $method], $pathParts);

} catch (\Exception $e) {
    $controller = new ErrorController();
    echo $controller->error404($uri);
} catch (\Error $e) {
    $controller = new ErrorController();
    echo $controller->error500();

}

