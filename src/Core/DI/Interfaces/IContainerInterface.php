<?php

namespace App\Core\DI\Interfaces;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

interface IContainerInterface extends ContainerInterface
{
    /**
     * @param string $id
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function getByTag(string $id): array;

}