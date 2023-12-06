<?php

namespace Alewea\Mymoney\core;

use Alewea\Mymoney\core\Database;
use PDO;
class Model extends Database
{
    static protected string $tableName = 'unknown_table';
    static protected array $enabledCols = [];

    public int $limit = 100;
    public int $offset = 0;

    public function validate($data)
    {
        return true;
    }

    public function filter_cols(array $data) : array
    {
        foreach ($data as $key => $value) {
            if(!in_array($key, static::$enabledCols))
            {
                unset($data[$key]);
            }
        }

        return $data;
    }

    public function findAll()
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' limit ' . $this->limit . ' offset ' . $this->offset;
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
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;

        $ret = $this->query($sql, $arr);
        return $ret->fetchAll();
    }

    public function whereOr(array $arr = [])
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' where ';
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= "$key = :$key OR ";
        }

        $sql = trim($sql, ' OR');
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;

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
        $sql .= ' limit ' . $this->limit . ' offset ' . $this->offset;
        $ret = $this->query($sql, $arr);
        return $ret->fetch();
    }

    public function add($arr)
    {
        $arr = $this->filter_cols($arr);
        $keys = array_keys($arr);

        $cols = implode(',', $keys);
        $vals = ':' . implode(',:', $keys);
        $sql = 'INSERT INTO ' . static::$tableName . ' (' . $cols . ') VALUES (' . $vals . ')';
                dd($sql);

        $ret = $this->query($sql, $arr);
        return Database::$db->lastinsertid();
        
    }

    public function update($id, $arr)
    {
        //UPDATE users SET last_name = :last_name WHERE id = 4
        $cols = '';
        foreach($arr as $key => $value)
        {
            $cols .= $key . '=:' . $key . ',';
        }
        $cols = trim($cols, ',');

        $sql = 'UPDATE ' . static::$tableName . ' SET ' . $cols . ' WHERE id=:id';
        $arr['id'] = $id;
        $ret = $this->query($sql, $arr);

        return $ret;
    }

    public function updateWhere($where, $arr)
    {
        //UPDATE users SET last_name = :last_name WHERE id = 4 ANt name='ss'
        $cols = '';
        foreach($arr as $key => $value)
        {
            $cols .= $key . '=:' . $key . ',';
        }
        $cols = trim($cols, ',');

        $whereStr = '';
        foreach($where as $key => $value)
        {
            $whereStr .= $key . '=:' . $key . ' AND ';
        }
        $whereStr = rtrim($whereStr, ' AND ');

        $sql = 'UPDATE ' . static::$tableName . ' SET ' . $cols . ' WHERE ' . $whereStr;

        $args = array_merge($arr, $where);
        $ret = $this->query($sql, $args);

        return $args;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM ' . static::$tableName . ' WHERE id=:id';
        $ret = $this->query($sql, ['id'=>$id]);

        return $ret;
    }

    public function deleteBy($col, $val)
    {
        $sql = 'DELETE FROM ' . static::$tableName . " WHERE $col = :$col";
        $ret = $this->query($sql, [$col=>$val]);

        return $ret;
    }

    public function deleteWhere($arr)
    {
        $sql = 'DELETE FROM ' . static::$tableName . " WHERE ";
        $keys = array_keys($arr);
        foreach($keys as $key)
        {
            $sql .= " $key = :$key AND";
        }

        $sql = rtrim($sql, ' AND');
        $ret = $this->query($sql, $arr);

        return $ret->rowCount();
    }

    public function search($fields, $search)
    {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ';
        $search = '%' . $search . '%';
        $str = '';
        foreach($fields as $field)
        {
            $str .= $field . ' LIKE :search OR ';
        }
        $str = trim($str, ' OR ');
        $sql .= $str;
        $sql .= ' LIMIT ' . $this->limit . ' OFFSET ' . $this->offset;
        $ret = $this->query($sql, ['search' => $search]);
        return $ret->fetchAll();
    }
}