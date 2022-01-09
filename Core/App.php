<?php

namespace Datnn\Core;

use Dotenv\Dotenv;
use Notihnio\RequestParser\RequestParser;


class App
{
    use JsonResponse;
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
        $c = include_once __DIR__ . "/.." . $_SERVER['PATH_INFO'] . "/index.php";

        if (!$c) {
            echo JsonResponse::get_response(404, "Route not found");
        }
    }
}
