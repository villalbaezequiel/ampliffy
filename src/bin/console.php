<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/Configs.php';

use App\Commands\CommitMsgCommand;
use App\Commands\PostCommitCommand;
use Symfony\Component\Console\Application;
use App\Services\ConnectionService;

$initConnection = new ConnectionService($db);
$commitMsgCommand = new CommitMsgCommand();
$postCommitCommand = new PostCommitCommand();

$application = new Application();
$application->add($commitMsgCommand);
$application->add($postCommitCommand);

$application->run();
