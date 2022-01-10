<?php

namespace Datnn\Controller;

use Datnn\Validator\CreateSongValidator;
use Datnn\Validator\UpdateSongValidator;
use Datnn\Repositories\SongRepository;

class SongController extends BaseController {
    private $song_repo;

    public function __construct() {
        $this->song_repo = new SongRepository();
    }

    public function all($request) {
        $page = $_REQUEST['page'] ?? 1;
        $per_page = $_REQUEST['per_page'] ?? 5;

        if (is_numeric($page)) {
            $page = intval($page);
            $per_page = \intval($per_page);

            $songs = $this->song_repo->getAllPagination($page, $per_page);

            echo $this->getResponse(200, "", array(
                'current_page' => intval($page),
                'per_page' => $per_page,
                'result' => $songs
            ));
        } else {
            echo $this->getResponse(422, "Invalid page number");
        }
    }

    public function get($request) {
        if (is_numeric($request['id'])) {
            $song = $this->song_repo->get($request['id']);
            if ($song) {
                echo $this->getResponse(200, "", $song);
            } else {
                echo $this->getResponse(404, "Song not found");
            }
        } else {
            echo $this->getResponse(422, "Invalid id");
        }
    }

    public function store($request) {
        (new CreateSongValidator($_POST))->validate();

        $song = $this->song_repo->create([
            'title' => ['value' => $_POST['title'], 'type' => \PDO::PARAM_STR],
            'album_name' => ['value' => $_POST['album_name'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $_POST['year'], 'type' => \PDO::PARAM_STR],
            'artist_name' => ['value' => $_POST['artist_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $_POST['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        echo $song ?
            $this->getResponse(200, "Create successfully", $song) :
            $this->getResponse(400, "Create failed");
    }

    public function update($request) {
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);
        if (is_numeric($request['id'])) {
            $song = $this->song_repo->get($request['id']);
            if ($song) {
                (new UpdateSongValidator($post_data))->validate();

                $updateSong = $this->song_repo->update([
                    'title' => ['value' => $post_data['title'] ?? $song['title'], 'type' => \PDO::PARAM_STR],
                    'album_name' => ['value' => $post_data['album_name'] ?? $song['album_name'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $post_data['year'] ?? $song['year'], 'type' => \PDO::PARAM_STR],
                    'artist_name' => ['value' => $post_data['artist_name'] ?? $song['artist_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $post_data['release_date'] ?? $song['release_date'], 'type' => \PDO::PARAM_STR],
                ], $request['id']);

                echo $updateSong ?
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
            $delete_song = $this->song_repo->delete($request['id']);
            echo $delete_song ? 
                $this->getResponse(200, "Delete song successfully!") : 
                $this->getResponse(404, "Song not found");;
        } else {
            echo $this->getResponse(422, "Invalid id");
            exit();
        }
    }
}