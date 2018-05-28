<?php

declare(strict_types=1);

return [
    'channel' => 'app',
    'level' => ('prod' === \getenv('APP_ENV')) ? \Monolog\Logger::WARNING : \Monolog\Logger::DEBUG,
];
