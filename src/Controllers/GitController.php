<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Repository;
use App\Models\Branch;
use App\Models\Commit;

class GitController extends BaseController
{
    
    public function getRepositories(Request $request, Response $response, array $arg)
    {
        try {
            $data = Repository::all()->toJson();

            $response->getBody()->write($data);

            return $response->withHeader('Content-Type', 'application/json')->withStatus(201); 

        } catch (\Exception $err) {
            // priority one Slim Application Error, catch this
            return 'ERROR('.$err->getLine().'): '.$err->getMessage();;
        }
    }

    public function getBranches(Request $request, Response $response, array $arg)
    {
        try {
            $data = Branch::where('id_repository', $arg['id_repository'])->get()->toJson();

            $response->getBody()->write($data);

            return $response->withHeader('Content-Type', 'application/json')->withStatus(201); 

        } catch (\Exception $err) {
            // priority one Slim Application Error, catch this
            return 'ERROR('.$err->getLine().'): '.$err->getMessage();;
        }
    }

    public function getCommits(Request $request, Response $response, array $arg)
    {
        try {
            $data = Commit::where('id_branch', $arg['id_branch'])->get()->toJson();

            $response->getBody()->write($data);

            return $response->withHeader('Content-Type', 'application/json')->withStatus(201); 

        } catch (\Exception $err) {
            // priority one Slim Application Error, catch this
            return 'ERROR('.$err->getLine().'): '.$err->getMessage();;
        }
    }
}
