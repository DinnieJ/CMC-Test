<?php

use Datnn\Repositories\MovieRepository;
use Datnn\Core\JsonResponse;

$movie_repo = new MovieRepository();

$page = $_REQUEST['page'] ?? 1;

if (is_numeric($page)) {
    $page = intval($page);
    $per_page = 5;

    $movies = $movie_repo->getAllPagination($page);

    echo JsonResponse::get_response(200, "", array(
        'current_page' => intval($page),
        'per_page' => $per_page,
        'result' => $movies
    ));
} else {
    echo JsonResponse::get_response(422, "Invalid page number");
}
