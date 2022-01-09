<?php

use Datnn\Repositories\SongRepository;
use Datnn\Core\JsonResponse;

$song_repository = new SongRepository();

switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(is_numeric($_REQUEST['id'])) {
            $song = $song_repository->get($_REQUEST['id']);
            if($song) {
                echo JsonResponse::get_response(200, "", $song);
            } else {
                echo JsonResponse::get_response(404, "Song not found");
            }
        } else {
            echo "invalid";
        }
        break;
    case 'POST':
        
        break;
    default:
        echo json_encode([
            'status' => 'false',
            'message' => 'Method not found'
        ]);
        break;
}