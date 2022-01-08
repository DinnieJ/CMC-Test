<?php

use Datnn\Controllers\IndexController;
use Datnn\Core\Controller;

require_once __DIR__. '/vendor/autoload.php';

use Datnn\Core\App;

header('Content-Type: application/json');

(new App())->run();