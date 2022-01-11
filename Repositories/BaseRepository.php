<?php

namespace Datnn\Repositories;

use Datnn\Database\MysqlConnector;

abstract class BaseRepository
{
    protected $connector;

    protected $tableName;

    public function __construct()
    {
        $this->connector = new MysqlConnector();
        $this->tableName = $this->getTableName();
    }


    abstract function getTableName();

    public function getAllPagination($page, $limit = 5)
    {

        $starting_limit = ($page - 1) * $limit;

        $queryAll  = "SELECT * FROM `$this->tableName` LIMIT :starter,:limit_page";

        try {
            $stmt = $this->connector->getConnection()->prepare($queryAll);
            $stmt->bindParam(':starter', $starting_limit, \PDO::PARAM_INT);
            $stmt->bindParam(':limit_page', $limit, \PDO::PARAM_INT);
            $stmt->execute();

            $data = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        } catch (\Exception $e) {
             return [];
        }
    }

    public function get($id)
    {
        $query  = "SELECT * FROM `$this->tableName` WHERE `id`= :table_id";
        try {
            $stmt = $this->connector->getConnection()->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));

            $stmt->bindParam(':table_id', \intval($id), \PDO::PARAM_INT);

            $stmt->execute();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                return $row;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function create($data)
    {
        $selected_cols = \array_keys($data);
        $cols = \implode('`,`', $selected_cols);
        $cols = '(`' . $cols . '`)';

        $val_params = \array_map(function ($item) {
            return ':' . $item;
        }, $selected_cols);

        $vals = '(' . \implode(',', $val_params) . ')';
        $query = "INSERT INTO `$this->tableName` $cols VALUES $vals";

        $stmt = $this->connector->getConnection()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindParam(':' . $key, $value['value'], $value['type']);
        }

        try {
            $stmt->execute();
            return $this->connector->getConnection()->lastInsertId();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function update($data, $id)
    {
        $selected_cols = \array_keys($data);
        $query = "UPDATE `$this->tableName` SET ";

        $update_col_strings = array_map(function ($col) {
            return "`$col` = :$col" . " ";
        }, $selected_cols);

        $update_col_string = implode(',', $update_col_strings);
        $query .= $update_col_string;
        $query .= " WHERE `id` = :rid";

        $stmt = $this->connector->getConnection()->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindParam(':' . $key, $value['value'], $value['type']);
        }

        $stmt->bindParam(':rid', \intval($id), \PDO::PARAM_INT);

        try {
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function delete($id)
    {
        $query = "DELETE FROM `$this->tableName` WHERE `id`= :table_id";
        try {
            $stmt = $this->connector->getConnection()->prepare($query);
            $stmt->bindParam(':table_id', \intval($id), \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\Exception $e) {
            return false;
        }
    }
}
