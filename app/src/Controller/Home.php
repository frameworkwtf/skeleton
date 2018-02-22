<?php

declare(strict_types=1);

namespace App\Controller;

class Home extends \App\Controller
{
    public function indexAction()
    {
        return $this->response->write('Home, sweet home!');
    }

    public function secondAction()
    {
        return $this->response->write('Home, sweet second home!');
    }
}
