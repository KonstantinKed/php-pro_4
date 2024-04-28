<?php

return array_merge(
    require_once __DIR__ . '/../config/core.php',
    require_once __DIR__ . '/../config/cli.php',
    require_once __DIR__ . '/../config/services.php',
    require_once __DIR__ . '/../config/calculator_configs.php',
    require_once __DIR__ . '/../config/web.php',
);
