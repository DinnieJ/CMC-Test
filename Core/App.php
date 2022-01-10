<?php

namespace Datnn\Core;

use Dotenv\Dotenv;
use Datnn\Core\Router;


class App
{
    // use JsonResponse;
    private $routes;


    public function __construct()
    {
        //load env
        $dotenv = Dotenv::createImmutable(__DIR__. "/../");
        $dotenv->load();

        //load config header
        require_once __DIR__. "/../config/app.php";
    }

    public function run()
    {
        Router::load();
    }
}
