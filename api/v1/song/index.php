<?php

use Datnn\Repositories\SongRepository;
use Datnn\Core\JsonResponse;
use Datnn\Validator\CreateSongValidator;
use Datnn\Validator\UpdateSongValidator;
use Datnn\Core\Controller;

(new class() extends Controller
{
    private $song_repo;

    public function __construct()
    {
        $this->song_repo = new SongRepository();
    }

    protected function doGet()
    {
        if (is_numeric($_REQUEST['id'])) {
            $song = $this->song_repo->get($_REQUEST['id']);
            if ($song) {
                echo JsonResponse::getResponse(200, "", $song);
            } else {
                echo JsonResponse::getResponse(404, "Song not found");
            }
        } else {
            echo JsonResponse::getResponse(422, "Invalid id");
        }
    }

    protected function doPost()
    {
        (new CreateSongValidator($_POST))->validate();

        $song = $this->song_repo->create([
            'title' => ['value' => $_POST['title'], 'type' => \PDO::PARAM_STR],
            'album_name' => ['value' => $_POST['album_name'], 'type' => \PDO::PARAM_STR],
            'year' => ['value' => $_POST['year'], 'type' => \PDO::PARAM_STR],
            'artist_name' => ['value' => $_POST['artist_name'], 'type' => \PDO::PARAM_STR],
            'release_date' => ['value' => $_POST['release_date'], 'type' => \PDO::PARAM_STR],
        ]);

        echo $song ?
            JsonResponse::getResponse(200, "Create successfully", $song) :
            JsonResponse::getResponse(400, "Create failed");
    }

    protected function doPut()
    {
        $data = file_get_contents("php://input");
        parse_str($data, $post_data);
        if (is_numeric($post_data['id'])) {
            $song = $this->song_repo->get($post_data['id']);
            if ($song) {
                (new UpdateSongValidator($post_data))->validate();
                $updateSong = $this->song_repo->update([
                    'title' => ['value' => $post_data['title'] ?? $song['title'], 'type' => \PDO::PARAM_STR],
                    'album_name' => ['value' => $post_data['album_name'] ?? $song['album_name'], 'type' => \PDO::PARAM_STR],
                    'year' => ['value' => $post_data['year'] ?? $song['year'], 'type' => \PDO::PARAM_STR],
                    'artist_name' => ['value' => $post_data['artist_name'] ?? $song['artist_name'], 'type' => \PDO::PARAM_STR],
                    'release_date' => ['value' => $post_data['release_date'] ?? $song['release_date'], 'type' => \PDO::PARAM_STR],
                ], $post_data['id']);

                echo $updateSong ?
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
            $delete_song = $this->song_repo->delete($post_data['id']);
            echo $delete_song ? 
                JsonResponse::getResponse(200, "Delete song successfully!") : 
                JsonResponse::getResponse(404, "Song not found");;
        } else {
            echo JsonResponse::getResponse(422, "Invalid id");
            exit();
        }
    }
})();
