<?php

declare(strict_types=1);

return [
    'namespace' => '\App\Entity\\',
    'database_type' => 'mysql',
    'database_name' => \getenv('DB_NAME'),
    'server' => \getenv('DB_HOST'),
    'username' => \getenv('DB_USER'),
    'password' => \getenv('DB_PASSWORD'),
    'charset' => 'utf8',
    'port' => 3306,
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];
