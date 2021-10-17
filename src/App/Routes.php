<?php

use Slim\Routing\RouteCollectorProxy;

$app->group('/api/v1', function(RouteCollectorProxy $group){
    $group->get('/repositories', 'App\Controllers\GitController:getRepositories');
    $group->get('/branchs/{repo}', 'App\Controllers\GitController:getBranchs');
    $group->get('/commits/{repo}/{branch}', 'App\Controllers\GitController:getCommits');
});
