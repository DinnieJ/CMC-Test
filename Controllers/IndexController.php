<?php

namespace Datnn\Controllers;
use Datnn\Core\Controller;

class IndexController extends Controller  {
    public function __construct()
    {
        parent::__construct();
    }
    public function index() {
        echo json_encode($_POST["id"]);
    }
}