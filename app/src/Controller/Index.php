<?php

declare(strict_types=1);

namespace App\Controller;

class Index extends \App\Controller
{
    public function indexAction()
    {
        return $this->response->write('Hello, world!');
    }

    public function secondAction()
    {
        return $this->response->write('Hello, second world!');
    }
}
