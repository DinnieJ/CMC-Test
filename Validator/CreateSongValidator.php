<?php
namespace Datnn\Validator;

use Datnn\Core\JsonResponse;
use Datnn\Core\Validator\Validator;

class CreateSongValidator extends Validator {
    protected function rules() {
        return [
            'title' => 'required|max:150',
            'album_name' => 'required|max:150',
            'year' => 'required|number|length:4',
            'artist_name' => 'required|max:100',
            'release_date' => 'required|datetimesql'
        ];
    }

    protected function responsesError() {
        echo JsonResponse::getResponse(422, "Invalid data");
    }
}