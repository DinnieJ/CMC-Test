<?php

namespace Datnn\Core;

class App {
    private $routes;

    public function __construct()
    {
    }

    public function run() {
        $uri = $_SERVER["REQUEST_URI"];

        $this->findMatchingRoute();
        $this->loadRoutes();
        
        echo json_encode($this->getRouteReg());
    }

    private function getMethod() {
        return \strtolower($_SERVER["REQUEST_METHOD"]);
    }

    private function findMatchingRoute() {
        $keys = array_keys($this->routes);
        $matchingKeys = preg_grep('/\/song\/.+/', $keys);
        $filteredArray = array_intersect_key($this->routes, array_flip($matchingKeys));
        print_r($matchingKeys);
    }

    private function getRouteReg() {
        $uri = $_SERVER["REQUEST_URI"];
        $split = preg_split("/\//", $uri);
        if($split[0] == "") unset($split[0]);

        return $split;
    }

    private function loadRoutes() {
        $routes = require_once __DIR__ . "/../routes.php";
        foreach($routes as $key => &$value) {
            $value["reg"] = preg_replace('/\/{.+}\/|\/{.+}/i', "/.+", $key);;
        }

        echo json_encode($routes);
    }
}