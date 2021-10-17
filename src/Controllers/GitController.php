<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\Helpers;
use App\Models\Repository;
use App\Models\Branch;
use App\Models\Commit;

class GitController extends BaseController
{
    protected $helpers;

    public function __construct(Helpers $helpers)
    {
        $this->helpers = $helpers;
    }

    public function getRepositories(Request $request, Response $response, array $arg)
    {
        return Repository::all()->toJson();
    }

    public function getBranchs(Request $request, Response $response, array $arg)
    {
        return Branch::all()->toJson();
    }

    public function getCommits(Request $request, Response $response, array $arg)
    {
        return Commit::all()->toJson();
    }
}
