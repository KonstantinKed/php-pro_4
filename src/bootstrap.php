<?php


use App\Core\ConfigHandler;
use App\Core\DI\Container;

require_once __DIR__ . '/../vendor/autoload.php';


return new Container(
    require_once __DIR__ . '/../config/compare.php',
    ConfigHandler::getInstance()->addConfigs(
        require_once __DIR__ . '/../config/params.php'
    )
);