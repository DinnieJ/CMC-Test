<?php

namespace Datnn\Repositories;
use Datnn\Repositories\BaseRepository;

class MovieRepository extends BaseRepository {
    public function getTableName() {
        return 'movie';
    }  
}