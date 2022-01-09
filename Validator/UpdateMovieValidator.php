<?php

namespace Datnn\Validator;

use Datnn\Core\Validator\Validator;
use Datnn\Core\JsonResponse;

class UpdateMovieValidator extends Validator
{

    protected function rules()
    {
        return [
            'title' => 'max:150',
            'description' => 'max:300',
            'year' => 'number',
            'director_name' => 'max:100',
            'release_date' => 'datetimesql'
        ];
    }

    protected function responsesError()
    {
        echo JsonResponse::getResponse(422, "Invalid data");
    }
}
