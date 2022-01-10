<?php

$router->route('songs', ['controller' => 'SongController', 'action' => 'all', 'method' => 'GET']);
$router->route('songs', ['controller' => 'SongController', 'action' => 'store', 'method' => 'POST']);
$router->route('songs/{id}', ['controller' => 'SongController', 'action' => 'get', 'method' => 'GET']);
$router->route('songs/{id}', ['controller' => 'SongController', 'action' => 'delete', 'method' => 'DELETE']);
$router->route('songs/{id}', ['controller' => 'SongController', 'action' => 'update', 'method' => 'PUT']);

$router->route('movies', ['controller' => 'MovieController', 'action' => 'all', 'method' => 'GET']);
$router->route('movies', ['controller' => 'MovieController', 'action' => 'store', 'method' => 'POST']);
$router->route('movies/{id}', ['controller' => 'MovieController', 'action' => 'get', 'method' => 'GET']);
$router->route('movies/{id}', ['controller' => 'MovieController', 'action' => 'delete', 'method' => 'DELETE']);
$router->route('movies/{id}', ['controller' => 'MovieController', 'action' => 'update', 'method' => 'PUT']);


