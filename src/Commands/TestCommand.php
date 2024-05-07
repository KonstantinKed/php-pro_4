<?php


namespace App\Commands;


use App\Core\CLI\Commands\AbstractCommand;

class TestCommand extends AbstractCommand
{
    protected function runAction(): string
    {
        return 'Result for test command';
    }

    public static function getCommandDesc(): string
    {
        return 'This command demonstrates a simple use of the CLI';
    }
}
