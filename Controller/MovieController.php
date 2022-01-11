<?php
namespace Datnn\Controller;

use Datnn\Repositories\MovieRepository;
use Datnn\Validator\CreateMovieValidator;
use Datnn\Validator\UpdateMovieValidator;

class MovieController extends BaseController {
    private $movie_repo;

    public function __construct() {
        $this->movie_repo = new MovieRepository();
    }

    public function all($request) {
        $page = $request->query['page'] ?? 1;
        $limit= $request->query['limit'] ?? 5;

        if (is_numeric($page)) {
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
    public function get($request) {
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

    public function store($request) {
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

    public function update($request) {
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);

        (new UpdateMovieValidator($post_data))->validate();
        if (is_numeric($request['id'])) {
            $movie = $this->movie_repo->get($request['id']);
            if ($movie) {
                $updateMovie = $this->movie_repo->update([
                    'title' => ['value' => $post_data['title'] ?? $movie['title'], 'type' => \PDO::PARAM_STR],
                    'description' => ['value' => $post_data['description'] ?? $movie['description'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $post_data['year'] ?? $movie['year'], 'type' => \PDO::PARAM_STR],
                    'director_name' => ['value' => $post_data['director_name'] ?? $movie['director_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $post_data['release_date'] ?? $movie['release_date'], 'type' => \PDO::PARAM_STR],
                ], $request['id']);

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

    public function delete($request) {
        
        if (is_numeric($request['id'])) {
            $delete_movie = $this->movie_repo->delete($request['id']);
            echo $delete_movie ? 
                $this->getResponse(200, "Delete movie successfully!") : 
                $this->getResponse(404, "Movie not found");;
        } else {
            echo $this->getResponse(422, "Invalid id");
            exit();
        }
    }
}