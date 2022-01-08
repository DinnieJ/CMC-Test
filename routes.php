<?php

return [
    "/" => [
        "GET" => "IndexController@index",
    ],
    "/song" => [
        "GET" => "SongController@all",
        "POST" => "SongController@store",
        "PUT" => "SongController@update",
        "DELETE" => "SongController@delete"
    ],
    
    "/song" => [
        "GET" => "SongController@get"
    ],

    "/movie" => [
        "GET" => "MovieController@all",
        "POST" => "MovieController@store",
        "PUT" => "MovieController@update",
        "DELETE" => "MovieController@delete"
    ],
    
    "/movie/{id}" => [
        "GET" => "MovieController@get"
    ]


];