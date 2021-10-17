<?php

use App\Services\ConnectionService;
use Psr\Container\ContainerInterface;

$container->set('connection_db',function(ContainerInterface $cont) {
    return new ConnectionService($cont->get('db'));
});
