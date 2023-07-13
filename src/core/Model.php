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

    }

    public function where($colName, $value)
    {

    }

    public function first(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . self::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key =: $key AND ";
        }

        $sql = trim($sql, ' AND');
        dd($sql);die;
        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
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