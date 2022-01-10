<?php

$router->route('song', ['controller' => 'SongController', 'action' => 'all', 'method' => 'GET']);
$router->route('song', ['controller' => 'SongController', 'action' => 'store', 'method' => 'POST']);
$router->route('song/{id}', ['controller' => 'SongController', 'action' => 'get', 'method' => 'GET']);
$router->route('song/{id}', ['controller' => 'SongController', 'action' => 'delete', 'method' => 'DELETE']);
$router->route('song/{id}', ['controller' => 'SongController', 'action' => 'update', 'method' => 'PUT']);

$router->route('movie', ['controller' => 'MovieController', 'action' => 'all', 'method' => 'GET']);
$router->route('movie', ['controller' => 'MovieController', 'action' => 'store', 'method' => 'POST']);
$router->route('movie/{id}', ['controller' => 'MovieController', 'action' => 'get', 'method' => 'GET']);
$router->route('movie/{id}', ['controller' => 'MovieController', 'action' => 'delete', 'method' => 'DELETE']);
$router->route('movie/{id}', ['controller' => 'MovieController', 'action' => 'update', 'method' => 'PUT']);


