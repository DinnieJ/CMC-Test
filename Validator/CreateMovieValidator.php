<?php

namespace Datnn\Validator;

use Datnn\Core\JsonResponse;
use Datnn\Core\Validator\Validator;

class CreateMovieValidator extends Validator {

    protected function rules() {
        return [
            'title' => 'required|max:150',
            'description' => 'required|max:300',
            'year' => 'required|number|length:4',
            'director_name' => 'required|max:100',
            'release_date' => 'required|datetimesql'
        ];
    }

    protected function responsesError() {
        echo JsonResponse::getResponse(422, "Invalid data");
    }
}