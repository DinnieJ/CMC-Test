<?php

use Datnn\Repositories\MovieRepository;
use Datnn\Core\JsonResponse;
use Datnn\Validator\CreateMovieValidator;
use Datnn\Validator\UpdateMovieValidator;
use Datnn\Core\Controller;

(new class() extends Controller
{
    private $movie_repo;

    public function __construct()
    {
        $this->movie_repo = new MovieRepository();
    }

    protected function doGet()
    {
        if (is_numeric($_REQUEST['id'])) {
            $movie = $this->movie_repo->get($_REQUEST['id']);
            if ($movie) {
                echo JsonResponse::getResponse(200, "", $movie);
            } else {
                echo JsonResponse::getResponse(404, "Movie not found");
            }
        } else {
            echo JsonResponse::getResponse(422, "Invalid id");
        }
    }

    protected function doPost()
    {
        (new CreateMovieValidator($_POST))->validate();

        $movie = $this->movie_repo->create([
            'title' => ['value' => $_POST['title'], 'type' => \PDO::PARAM_STR],
            'description' => ['value' => $_POST['description'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $_POST['year'], 'type' => \PDO::PARAM_STR],
            'director_name' => ['value' => $_POST['director_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $_POST['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        echo $movie ?
            JsonResponse::getResponse(200, "Create successfully", $movie) :
            JsonResponse::getResponse(422, "Create failed");
    }

    protected function doPut()
    {
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);

        (new UpdateMovieValidator($post_data))->validate();
        if (is_numeric($post_data['id'])) {
            $movie = $this->movie_repo->get($post_data['id']);
            if ($movie) {

                $updateMovie = $this->movie_repo->update([
                    'title' => ['value' => $post_data['title'] ?? $movie['title'], 'type' => \PDO::PARAM_STR],
                    'description' => ['value' => $post_data['description'] ?? $movie['description'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $post_data['year'] ?? $movie['year'], 'type' => \PDO::PARAM_STR],
                    'director_name' => ['value' => $post_data['director_name'] ?? $movie['director_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $post_data['release_date'] ?? $movie['release_date'], 'type' => \PDO::PARAM_STR],
                ], $post_data['id']);

                echo $updateMovie ?
                    JsonResponse::getResponse(200, "Update successfully") :
                    JsonResponse::getResponse(401, "Update failed");
            } else {
                echo JsonResponse::getResponse(404, "Movie not found");
            }
        } else {
            echo JsonResponse::getResponse(422, "Invalid id");
        }
    }

    protected function doDelete()
    {
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);
        if (is_numeric($post_data['id'])) {
            $delete_movie = $this->movie_repo->delete($post_data['id']);
            echo $delete_movie ? 
                JsonResponse::getResponse(200, "Delete movie successfully!") : 
                JsonResponse::getResponse(404, "Movie not found");;
        } else {
            echo JsonResponse::getResponse(422, "Invalid id");
            exit();
        }
    }
})();
