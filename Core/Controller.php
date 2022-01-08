<?php

namespace Datnn\Core;

abstract class Controller {

    private $request;
    private $response;
    
    public function __construct()
    {
        header("Content-Type: application/json");
    }
}