
<?php
return [
    'shortener' => [
        'b' => [
            'c' => 123
        ]
    ],
    'curl' => [
        'method' => 'post',
    ],
    'dbFile' => __DIR__ . '/../storage/db.json',
    'db' => [
        'mysql' => [
            'type' => 'mysql',
            'host' => 'db_mysql',
            'port' => '13306',
            'dbname' => 'base',
            'user' => 'doctor',
            'pass' => 'pass4doctor',
        ],
    ],
    'devMode' => true,
    'monolog' => [
        'channel' => 'general',
        'level' => [
            'error' => __DIR__ . '/../var/logs/error.log',
            'info' => __DIR__ . '/../var/logs/info.log',
            'debug' => __DIR__ . '/../var/logs/debug.log',
            'notice' => __DIR__ . '/../var/logs/notice.log',
        ],
    ],
    'urlConverter' => [
        'codeLength' => 8,
        'unique' => true,
    ],
];
