<?php


namespace App\Commands;

use App\Core\CLI\Interfaces\ICliCommand;

class HelloUserCommand implements ICliCommand
{

    /**
     * @inheritDoc
     */
    public static function getCommandName(): string
    {
        return 'hello_user';
    }

    /**
     * @inheritDoc
     */
    public static function getCommandDesc(): string
    {
        return 'Print hello by name';
    }

    /**
     * @inheritDoc
     */
    public function run(array $params = []): void
    {
        echo 'Hello, ' . $params[0] . PHP_EOL;
    }
}
