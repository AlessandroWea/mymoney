<?php

namespace Alewea\Mymoney\core;

use \PDO;

class Database
{
    public static $db = null;

    public static function connect()
    {
        if(static::$db == null)
            return static::$db = new PDO('mysql:host='. DB_HOST .';dbname=' . DB_NAME, DB_USER, DB_PWD);
        
        return static::$db;
    }

    public static function beginTransaction()
    {
        $db = Database::connect();
        $db->beginTransaction();
    }

    public static function commit()
    {
        static::$db->commit();
    }

    public static function rollBack()
    {
        static::$db->rollBack();
    }

    public function query($sql, $arr = [])
    {
        $db = Database::connect();
        $query = $db->prepare($sql);
        // dd($arr);
        // if(isset($arr['cur_id']))
        // {
        //     $arr = ['cur_id' => 1];
        //       dd($arr);
      
        // }
        $query->execute($arr);
        $errInfo = $query->errorInfo();
        if($errInfo[0] !== PDO::ERR_NONE)
        {
            echo $errInfo[2];
            exit();
        }
        $db = null;
        return $query;
    }

    public function create_users_table()
    {
        $query = "
            DROP TABLE IF EXISTS users; CREATE TABLE users (
                id int NOT NULL AUTO_INCREMENT,
                username varchar(256) NOT NULL,
                email varchar(256) NOT NULL,
                password varchar(256) NOT NULL,
                role int(1) NOT NULL,
                date datetime DEFAULT CURRENT_TIMESTAMP(),
                PRIMARY KEY (id)
            );
        ";

        $this->query($query);
    }

    public function create_categories_table()
    {
        $query = "
            DROP TABLE IF EXISTS categories; CREATE TABLE categories (
                id int NOT NULL AUTO_INCREMENT,
                type tinyint(1) NOT NULL,
                name varchar(256) NOT NULL,
                PRIMARY KEY (id)
            );
        ";

        $this->query($query);
    }

    public function create_accounts_table()
    {
        $query = "
            DROP TABLE IF EXISTS accounts; CREATE TABLE accounts (
                id int NOT NULL AUTO_INCREMENT,
                name varchar(256) NOT NULL DEFAULT 'main',
                user_id int NOT NULL,
                value int NOT NULL DEFAULT 0,
                PRIMARY KEY (id)
            );
        ";

        $this->query($query); 
        
    }

    public function create_operations_table()
    {
        $query = "
            DROP TABLE IF EXISTS operations; CREATE TABLE operations (
                id int NOT NULL AUTO_INCREMENT,
                category_id int NOT NULL,
                account_id int NOT NULL,
                value int NOT NULL,
                comment varchar(128),
                date DATE NOT NULL,
                PRIMARY KEY (id)
            );
        ";

        $this->query($query);
    }
}