
<?php

use App\Core\CLI\CommandHandler;
use App\Core\CLI\Commands\HelpCommand;
use App\Core\DI\Container;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;
use App\Core\DI\ValueObjects\ServiceObject;

return [
    // ----------- COMMANDS -----------

    CommandHandler::class => [
        S::CLASSNAME => CommandHandler::class,
        S::ARGUMENTS => [
            '@' . HelpCommand::class,
        ],
        S::COMPILER => function (Container $container, object $object, ServiceObject $refs) {
            /**
             * @var CommandHandler $object
             */
            foreach ($container->getByTag('cli.command') as $item) {
                $object->addCommand($item);
            }
        },
    ],

    HelpCommand::class => [
        S::CLASSNAME => HelpCommand::class,
        S::ARGUMENTS => [
            '$allowed.command',
        ],

        S::TAGS => ['cli.command']
    ],

];
