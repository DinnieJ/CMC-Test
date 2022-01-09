<?php

namespace Datnn\Repositories;

use Datnn\Repositories\BaseRepository;

class SongRepository extends BaseRepository
{
    public function getTableName()
    {
        return 'song';
    }
}
