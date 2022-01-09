<?php

namespace Datnn\Validator;

use Datnn\Core\JsonResponse;

class CreateMovieValidator extends Validator {

    protected function rules() {
        return [
            'title' => 'required|max:150',
            'description' => 'required|max:300',
            'year' => 'required|number',
            'director_name' => 'required|max:100',
            'release_date' => 'required|datetimesql'
        ];
    }

    protected function responsesError() {
        echo JsonResponse::get_response(422, "Invalid data");
    }
}