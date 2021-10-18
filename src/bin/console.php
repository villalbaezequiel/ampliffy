<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Commands\PreCommitCommand;
use Symfony\Component\Console\Application;

$command = new PreCommitCommand();

$application = new Application();
$application->add($command);

$application->run();
