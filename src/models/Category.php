<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Category extends Model
{
    static protected string $tableName = 'categories';
    static public array $enabledCols = ['type', 'name'];

    static public int $TYPE_INCOME = 0;
    static public int $TYPE_EXPENSIS = 1;

    public array $errors = [];

    public static function strTypeToIntType(string $type)
    {
        return $type == 'income' ? self::$TYPE_INCOME : self::$TYPE_EXPENSIS;
    }

}