<?php


namespace App\Core\DI\Ecxeptions;

use InvalidArgumentException;
use Psr\Container\ContainerExceptionInterface;

class ContainerException extends InvalidArgumentException implements ContainerExceptionInterface
{

}
