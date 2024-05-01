<?php


namespace App\Core\Exceptions;

use InvalidArgumentException;
use Psr\Container\NotFoundExceptionInterface;

class ParameterNotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{

}
