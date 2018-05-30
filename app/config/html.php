<?php

declare(strict_types=1);

return [
    'template_path' => __DIR__.'/../views/',
    'cache_path' => ('prod' === \getenv('APP_ENV')) ? __DIR__.'/../cache' : false,
];
