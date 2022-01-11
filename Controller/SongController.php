<?php

namespace Datnn\Controller;

use Datnn\Validator\CreateSongValidator;
use Datnn\Validator\UpdateSongValidator;
use Datnn\Repositories\SongRepository;
use Datnn\Core\HttpRequest;

class SongController extends BaseController {
    private $song_repo;

    public function __construct() {
        $this->song_repo = new SongRepository();
    }

    public function all($request) {
        $page = $request->query['page'] ?? 1;
        $per_page = $request->query['limit'] ?? 5;

        if (is_numeric($page) && $page > 0 && $per_page > 0) {
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

    public function get(HttpRequest $request) {
        if (is_numeric($request->params['id'])) {
            $song = $this->song_repo->get($request->params['id']);
            if ($song) {
                echo $this->getResponse(200, "", $song);
            } else {
                echo $this->getResponse(404, "Song not found");
            }
        } else {
            echo $this->getResponse(422, "Invalid id");
        }
    }

    public function store(HttpRequest $request) {
        (new CreateSongValidator($request->body))->validate();

        $song = $this->song_repo->create([
            'title' => ['value' => $request->body['title'], 'type' => \PDO::PARAM_STR],
            'album_name' => ['value' => $request->body['album_name'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $request->body['year'], 'type' => \PDO::PARAM_STR],
            'artist_name' => ['value' => $request->body['artist_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $request->body['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        echo $song ?
            $this->getResponse(200, "Create successfully", $song) :
            $this->getResponse(400, "Create failed");
    }

    public function update(HttpRequest $request) {
        if (is_numeric($request['id'])) {
            $song = $this->song_repo->get($request->params['id']);
            if ($song) {
                (new UpdateSongValidator($request->body))->validate();

                $updateSong = $this->song_repo->update([
                    'title' => ['value' => $request->body['title'] ?? $song['title'], 'type' => \PDO::PARAM_STR],
                    'album_name' => ['value' => $request->body['album_name'] ?? $song['album_name'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $request->body['year'] ?? $song['year'], 'type' => \PDO::PARAM_STR],
                    'artist_name' => ['value' => $request->body['artist_name'] ?? $song['artist_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $request->body['release_date'] ?? $song['release_date'], 'type' => \PDO::PARAM_STR],
                ], $request->params['id']);

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

    public function delete(HttpRequest $request) {
        if (is_numeric($request->params['id'])) {
            $delete_song = $this->song_repo->delete($request->params['id']);
            echo $delete_song ? 
                $this->getResponse(200, "Delete song successfully!") : 
                $this->getResponse(404, "Song not found");;
        } else {
            echo $this->getResponse(422, "Invalid id");
            exit();
        }
    }
}