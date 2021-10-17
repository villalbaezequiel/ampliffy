<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    protected $container;

    public function __construct(ContainerInterface $containerInterface)
    {
        $this->container = $containerInterface;
        // init connection db
        $this->container->get('connection_db');
    }
}
