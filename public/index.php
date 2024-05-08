
<?php

use App\Controllers\CalcController;
use App\Controllers\ErrorController;
use App\Controllers\ShortenerController;
use App\Controllers\ShortenerController_olf;
use App\Controllers\UserController;
use App\Core\Web\Exceptions\RouteNotFoundException;
use App\ORM\DataMapper\Entity\Shortener;
use App\Shortener\SuportActions\CodeGenerator;
use App\Shortener\SuportActions\SimpleUrlValidator;
use App\Shortener\UrlEncodeDecode;
use Doctrine\ORM\EntityManager;

$container = require_once __DIR__ . '/../src/bootstrap.php';

$uriLink = $_GET['url'];



try {
    $em = $container->get(EntityManager::class);
//    $controller = new ShortenerController($em);
    $controller = new ShortenerController_olf($em);
    echo $controller->action($uriLink);

} catch (\Exception $e) {
    $controller = new ErrorController();
    echo $controller->error404($uriLink);
} catch (\Error $e) {
    $controller = new ErrorController();
    echo $controller->error500();

}

