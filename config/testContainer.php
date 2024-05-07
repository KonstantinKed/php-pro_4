<?php

use App\Commands\TestCommand;
use App\Core\CLI\CommandHandler;
use App\Core\CLI\Commands\HelpCommand;

return [

    HelpCommand::class => function (TestContainer $container) {
        return new HelpCommand(
            [
                $container->get(TestCommand::class)
            ]
        );
    },
    TestCommand::class => function (TestContainer $container) {
        return new TestCommand();
    },
    CommandHandler::class => function (TestContainer $container) {
        return new CommandHandler($container->get(HelpCommand::class));
    },
];
