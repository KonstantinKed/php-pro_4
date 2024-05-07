<?php


namespace App\Core\CLI\Interfaces;

interface ICommandHandler
{
    /**
     * @param array $params
     * @param callable|null $callback
     * @return void
     */
    public function handle(array $params = [], ?callable $callback = null): void;
}
