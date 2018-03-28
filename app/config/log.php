<?php

declare(strict_types=1);

return [
    'channel' => 'app',
    'format' => "===LOG==ENTRY===\nMESSAGE |> %message%\nLEVEL   |> %level_name%\nCONTEXT |> %context%\nEXTRA   |> %extra%\n===END==ENTRY===\n",
    'level' => ('prod' === \getenv('APP_ENV')) ? \Monolog\Logger::WARNING : \Monolog\Logger::DEBUG,
];
