<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/api/v1', function(RouteCollectorProxy $group){
    $group->get('/repositories', 'App\Controllers\GitController:getRepositories');
    $group->get('/branches/{id_repository}', 'App\Controllers\GitController:getBranches');
    $group->get('/commits/{id_branch}', 'App\Controllers\GitController:getCommits');
});
