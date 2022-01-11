<?php
namespace Datnn\Controller;

use Datnn\Repositories\MovieRepository;
use Datnn\Validator\CreateMovieValidator;
use Datnn\Validator\UpdateMovieValidator;
use Datnn\Core\HttpRequest;

class MovieController extends BaseController {
    private $movie_repo;

    public function __construct() {
        $this->movie_repo = new MovieRepository();
    }

    public function all(HttpRequest $request) {
        $page = $request->query['page'] ?? 1;
        $limit= $request->query['limit'] ?? 5;

        if (is_numeric($page) && $page > 0 && $limit > 0) {
            $page = intval($page);
            $limit = intval($limit);

            $movies = $this->movie_repo->getAllPagination($page, $limit);

            echo $this->getResponse(200, "", array(
                'current_page' => intval($page),
                'per_page' => $limit,
                'result' => $movies
            ));
        } else {
            echo $this->getResponse(422, "Invalid page number");
        }
    }
    public function get(HttpRequest $request) {
        if (is_numeric($request->params['id'])) {
            $movie = $this->movie_repo->get($request->params['id']);
            if ($movie) {
                echo $this->getResponse(200, "", $movie);
            } else {
                echo $this->getResponse(404, "Movie not found");
            }
        } else {
            echo $this->getResponse(422, "Invalid id");
        }
    }

    public function store(HttpRequest $request) {
        (new CreateMovieValidator($_POST))->validate();

        $movie = $this->movie_repo->create([
            'title' => ['value' => $_POST['title'], 'type' => \PDO::PARAM_STR],
            'description' => ['value' => $_POST['description'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $_POST['year'], 'type' => \PDO::PARAM_STR],
            'director_name' => ['value' => $_POST['director_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $_POST['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        echo $movie ?
            $this->getResponse(200, "Create successfully", $movie) :
            $this->getResponse(422, "Create failed");
    }

    public function update(HttpRequest $request) {

        (new UpdateMovieValidator($request->body))->validate();

        if (is_numeric($request->params['id'])) {
            $movie = $this->movie_repo->get($request->params['id']);
            if ($movie) {
                $updateMovie = $this->movie_repo->update([
                    'title' => ['value' => $request->body['title'] ?? $movie['title'], 'type' => \PDO::PARAM_STR],
                    'description' => ['value' => $request->body['description'] ?? $movie['description'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $request->body['year'] ?? $movie['year'], 'type' => \PDO::PARAM_STR],
                    'director_name' => ['value' => $request->body['director_name'] ?? $movie['director_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $request->body['release_date'] ?? $movie['release_date'], 'type' => \PDO::PARAM_STR],
                ], $request->params['id']);

                echo $updateMovie ?
                    $this->getResponse(200, "Update successfully") :
                    $this->getResponse(401, "Update failed");
            } else {
                echo $this->getResponse(404, "Movie not found");
            }
        } else {
            echo $this->getResponse(422, "Invalid id");
        }
    }

    public function delete(HttpRequest $request) {

        if (is_numeric($request->params['id'])) {
            $delete_movie = $this->movie_repo->delete($request->params['id']);
            echo $delete_movie ? 
                $this->getResponse(200, "Delete movie successfully!") : 
                $this->getResponse(404, "Movie not found");;
        } else {
            echo $this->getResponse(422, "Invalid id");
            exit();
        }
    }
}