<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Amigos extends Model
{
    static protected string $tableName = 'amigos';
    static public array $enabledCols = ['accepted', 'user1_id', 'user2_id'];

}
