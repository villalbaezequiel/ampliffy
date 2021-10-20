<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Commands\CommitMsgCommand;
use App\Commands\PostCommitCommand;
use Symfony\Component\Console\Application;

$commitMsgCommand = new CommitMsgCommand();
$postCommitCommand = new PostCommitCommand();

$application = new Application();
$application->add($commitMsgCommand);
$application->add($postCommitCommand);

$application->run();
