<?php
namespace Datnn\Core;

class HttpRequest
{
    public $params;

    public $body;

    public $query;

    public $headers;

    public function __construct($uriParams = [])
    {
        $this->query = $_REQUEST;

        foreach($uriParams as $key => $value) {
            $this->params[$key] = $value;
        }
        
        $this->headers = array_filter($_SERVER, function ($key) {
            return strpos($key, 'HTTP_') === 0;
        }, ARRAY_FILTER_USE_KEY);
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->body = $_POST;
        } else {
            switch ($this->headers['HTTP_CONTENT_TYPE']) {
                case 'application/json':
                    $this->body = json_decode(file_get_contents('php://input'), true);
                    break;
                case 'application/x-www-form-urlencoded':
                    $data = file_get_contents("php://input");
                    parse_str($data, $post_data);
                    $this->body = $post_data;
                    break;
                default:
                    $this->body = [];
                    break;
            }
        }
    }
}
