<?php

use Datnn\Repositories\MovieRepository;
use Datnn\Core\JsonResponse;
use Datnn\Validator\CreateMovieValidator;
use Datnn\Validator\UpdateMovieValidator;

$movie_repo = new MovieRepository();

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(is_numeric($_REQUEST['id'])) {
            $movie = $movie_repo->get($_REQUEST['id']);
            if($movie) {
                echo JsonResponse::get_response(200, "", $movie);
            } else {
                echo JsonResponse::get_response(404, "Movie not found");
            }
        } else {
            echo JsonResponse::get_response(422, "Invalid id");
        }
        break;
    case 'POST':
        (new CreateMovieValidator($_POST))->validate();
        $movie = $movie_repo->create([
            'title' => ['value' => $_POST['title'], 'type' => \PDO::PARAM_STR],
            'description' => ['value' => $_POST['description'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $_POST['year'], 'type' => \PDO::PARAM_STR],
            'director_name' => ['value' => $_POST['director_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $_POST['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        if($movie) {
            echo JsonResponse::get_response(200, "Create successfully", $movie);
        } else {
            echo JsonResponse::get_response(422, "Create failed");
        }
        break;
    
    case 'PUT':
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);
        if(is_numeric($_REQUEST['id'])) {
            
            $movie = $movie_repo->get($_REQUEST['id']);

            if($movie) {
                (new UpdateMovieValidator($data))->validate();
                $updateMovie = $movie_repo->update([
                    'title' => ['value' => $post_data['title'] ?? $movie['title'], 'type' => \PDO::PARAM_STR],
                    'description' => ['value' => $post_data['description'] ?? $movie['description'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $post_data['year'] ?? $movie['year'], 'type' => \PDO::PARAM_STR],
                    'director_name' => ['value' => $post_data['director_name'] ?? $movie['director_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $post_data['release_date'] ?? $movie['release_date'], 'type' => \PDO::PARAM_STR],
                ], $_REQUEST['id']);

                if($updateMovie) {
                    echo JsonResponse::get_response(200, "Update successfully");
                } else {
                    echo JsonResponse::get_response(401, "Update failed");
                }
            } else {
                echo JsonResponse::get_response(404, "Movie not found");
            }
        } else {
            echo JsonResponse::get_response(422, "Invalid id");
        }
        break;
    case 'DELETE':
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);
        if(is_numeric($post_data['id'])) {
            $movie = $movie_repo->delete($post_data['id']);
            if($movie) {
                echo JsonResponse::get_response(200, "Delete movie successfully!");
            } else {
                echo JsonResponse::get_response(404, "Movie not found");
            }
        } else {
            echo JsonResponse::get_response(422, "Invalid id");
            exit();
        }
        break;
    
    default:
        echo JsonResponse::get_response(405, "Method not allowed");
        break;
}