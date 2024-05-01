<?php


namespace App\Core\DI\Ecxeptions;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{

}
