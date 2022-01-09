<?php

use Datnn\Repositories\MovieRepository;
use Datnn\Core\JsonResponse;
use Datnn\Core\Controller;

(new class() extends Controller
{
    private $movie_repo;
    public function __construct()
    {
        $this->movie_repo = new MovieRepository();
    }

    public function doGet()
    {
        $page = $_REQUEST['page'] ?? 1;

        if (is_numeric($page)) {
            $page = intval($page);
            $per_page = 5;

            $movies = $this->movie_repo->getAllPagination($page);

            echo JsonResponse::getResponse(200, "", array(
                'current_page' => intval($page),
                'per_page' => $per_page,
                'result' => $movies
            ));
        } else {
            echo JsonResponse::getResponse(422, "Invalid page number");
        }
    }
})();
