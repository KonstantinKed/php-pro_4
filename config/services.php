<?php


use App\Core\DI\Container;
use App\Core\DI\Enums\ServiceConfigArrayKeys as S;
use App\Core\DI\ValueObjects\ServiceObject;
use App\ORM\ActiveRecord\DatabaseAR;
use App\ORM\DataMapper\DatabaseDM;
use App\Shortener\FileRepository;
use App\Shortener\Helpers\UrlValidator;
use App\Shortener\UrlConverter;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;
use Illuminate\Database\Capsule\Manager;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

return [

    Manager::class => [
        S::CLASSNAME => DatabaseAR::class,
        S::ARGUMENTS => [
            '%db.mysql.dbname',
            '%db.mysql.user',
            '%db.mysql.pass',
            '%db.mysql.host',
        ],
    ],

    "orm.doctrine.creator" => [
        S::CLASSNAME => DatabaseDM::class,
        S::ARGUMENTS => [
            '%db.mysql.dbname',
            '%db.mysql.user',
            '%db.mysql.pass',
            '%db.mysql.host',
            '%devMode',
        ]
    ],
    EntityManager::class => [
        S::CLASSNAME => EntityManager::class,
        S::COMPOSITION => ["@orm.doctrine.creator" => 'getEM']
    ],

    "shortener.converter" => [
        S::CLASSNAME => UrlConverter::class,
        S::ARGUMENTS => [
            '@shortener.codeRepository',
            '@shortener.urlValidator',
            '%urlConverter.codeLength',
        ],
    ],

    "shortener.codeRepository" => [
        S::CLASSNAME => FileRepository::class,
        S::ARGUMENTS => [
            '%dbFile',
        ],
    ],
    "shortener.urlValidator" => [
        S::CLASSNAME => UrlValidator::class,
        S::ARGUMENTS => [
            '@guzzle.client',
        ],
    ],
    "guzzle.client" => [
        S::CLASSNAME => Client::class,
    ],
    "monolog.logger" => [
        S::CLASSNAME => Logger::class,
        S::ARGUMENTS => [
            '%monolog.channel',
        ],
        S::COMPILER => function (Container $container, object $object, ServiceObject $refs) {
            /**
             * @var Logger $object
             */
            foreach ($container->getByTag('monolog.stream') as $item) {
                $object->pushHandler($item);
            }
        },
    ],
//    "monolog.streamHandler.info" => [
//        S::CLASSNAME => StreamHandler::class,
//        S::ARGUMENTS => [
//            '%monolog.level.info',
//            Level::Info,
//        ],
//        S::TAGS => ['monolog.stream'],
//    ],
//    "monolog.streamHandler.error" => [
//        S::CLASSNAME => StreamHandler::class,
//        S::ARGUMENTS => [
//            '%monolog.level.error',
//            Level::Error,
//        ],
//        S::TAGS => ['monolog.stream'],
//    ],
//    "monolog.streamHandler.debug" => [
//        S::CLASSNAME => StreamHandler::class,
//        S::ARGUMENTS => [
//            '%monolog.level.debug',
//            Level::Debug,
//        ],
//        S::TAGS => ['monolog.stream'],
//    ],
//    "monolog.streamHandler.notice" => [
//        S::CLASSNAME => StreamHandler::class,
//        S::ARGUMENTS => [
//            '%monolog.level.notice',
//            Level::Notice,
//        ],
//        S::TAGS => ['monolog.stream'],
//    ],

];
