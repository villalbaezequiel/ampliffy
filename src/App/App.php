<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$initContainer = new \DI\Container();
AppFactory::setContainer($initContainer);

$app        = AppFactory::create();
$container  = $app->getContainer();

require __DIR__ . '/Configs.php';
require __DIR__ . '/Services.php';
require __DIR__ . '/Routes.php';

$app->addErrorMiddleware(true, true, true);

$app->run();
