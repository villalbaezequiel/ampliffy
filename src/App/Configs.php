<?php

$container->set('db', function(){
    return [
        'driver'    => 'mysql',
        'host'      => 'mysql',
        'database'  => 'challenge',
        'username'  => 'user',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ];
});
