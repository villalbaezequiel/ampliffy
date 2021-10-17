<?php

namespace App\Services;

use Illuminate\Database\Capsule\Manager;

class ConnectionService
{
    public function __construct($db)
    {
        $capsule = new Manager;
        $capsule->addConnection($db);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    }
}
