<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use App\Helpers\Helpers;

abstract class BaseController
{
    protected $container;
    protected $helpers;

    public function __construct(
        ContainerInterface $containerInterface,
        Helpers $helpers
    )
    {
        $this->helpers  = $helpers;
        $this->container= $containerInterface;
        // init connection db
        $this->container->get('connection_db');
    }
}
