<?php
namespace Datnn\Core;

trait JsonResponse {

    public static function get_response($code = 200, $message = "", $data = [])
    {

        header('Content-Type: application/json');
        http_response_code($code);
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            404 => '404 Not Found',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );

        header('Status: '.$status[$code]);
        return json_encode(array(
            'status' => $code < 300,
            'message' => $message,
            'data' => $data
        ));
    }
}