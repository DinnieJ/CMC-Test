<?php

use Datnn\Repositories\SongRepository;
use Datnn\Core\JsonResponse;

$song_repository = new SongRepository();

$page = $_REQUEST['page'] ?? 1;

if (is_numeric($page)) {
    $page = intval($page);
    $per_page = 5;

    $movies = $song_repository->getAllPagination($page);

    echo JsonResponse::get_response(200, "", array(
        'current_page' => intval($page),
        'per_page' => $per_page,
        'result' => $movies
    ));
} else {
    echo JsonResponse::get_response(422, "Invalid page number");
}
