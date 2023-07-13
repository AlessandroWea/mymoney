<?php

namespace Alewea\Mymoney\core;

use \PDO;

class Database
{
    public function connect()
    {
        return new PDO('mysql:host='. DB_HOST .';dbname=' . DB_NAME, DB_USER, DB_PWD);

    }

    public function query($sql, $arr = [])
    {
        $db = $this->connect();
        $query = $db->prepare($sql);
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

    public function create_user_table()
    {
        $query = "
            DROP TABLE IF EXISTS users; CREATE TABLE users (
                id int NOT NULL AUTO_INCREMENT,
                first_name varchar(64) NOT NULL,
                last_name varchar(64) NOT NULL,
                PRIMARY KEY (id)
            );
        ";

        // CREATE TABLE Persons (
        //     Personid int NOT NULL AUTO_INCREMENT,
        //     LastName varchar(255) NOT NULL,
        //     FirstName varchar(255),
        //     Age int,
        //     PRIMARY KEY (Personid)
        // );

        $this->query($query);
    }
}