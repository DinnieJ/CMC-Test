<?php

use Datnn\Repositories\SongRepository;
use Datnn\Core\JsonResponse;
use Datnn\Core\Controller;

(new class() extends Controller
{
    private $song_repo;
    public function __construct()
    {
        $this->song_repo = new SongRepository();
    }

    public function doGet()
    {
        $page = $_REQUEST['page'] ?? 1;

        if (is_numeric($page)) {
            $page = intval($page);
            $per_page = 5;

            $songs = $this->song_repo->getAllPagination($page);

            echo JsonResponse::getResponse(200, "", array(
                'current_page' => intval($page),
                'per_page' => $per_page,
                'result' => $songs
            ));
        } else {
            echo JsonResponse::getResponse(422, "Invalid page number");
        }
    }
})();
