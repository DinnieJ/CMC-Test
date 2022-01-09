<?php
namespace Datnn\Validator;

use Datnn\Core\JsonResponse;
use Datnn\Core\Validator\Validator;

class UpdateSongValidator extends Validator {
    protected function rules() {
        return [
            'title' => 'max:150',
            'album_name' => 'max:150',
            'year' => 'number|length:4',
            'artist_name' => 'max:100',
            'release_date' => 'datetimesql'
        ];
    }

    protected function responsesError() {
        echo JsonResponse::getResponse(422, "Invalid data");
    }
}