<?php

namespace Alewea\Mymoney\core;

use Alewea\Mymoney\core\Database;

class Model extends Database
{
    static protected string $tableName = 'unknown_table';
    static protected array $enabledCols = [];

    public function validate($data)
    {
        return true;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $ret = $this->query($sql);

        return $ret->fetchAll();
    }

    public function where(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
    }

    public function first(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key AND ";
        }

        $sql = trim($sql, ' AND');
        $ret = $this->query($sql, $arr);
        return $ret->fetch();
    }

    public function add($arr)
    {

    }

    public function update($id, $arr)
    {

    }

    public function delete($id)
    {

    }
}