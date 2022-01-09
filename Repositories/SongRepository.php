<?php

namespace Datnn\Repositories;

use Datnn\Repositories\BaseRepository;

class SongRepository extends BaseRepository
{
    public function getTableName()
    {
        return 'song';
    }

    public function create($data) {}

    public function delete($id) {}

    public function update($data, $id) {}

}
