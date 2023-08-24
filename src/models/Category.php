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

    public function validate($data)
    {
        if(empty($data['name']))
        {
            $this->errors['name'] = 'Name must not be empty!';
        }

        if(!isset($data['type']))
        {
            $this->errors['type'] = 'Type must be chosen!';
        } else if($data['type'] != self::$TYPE_INCOME && $data['type'] != self::$TYPE_EXPENSIS)
        {
            $this->errors['type'] = 'Invalid type';
        }

        return empty($this->errors) ? true : false;
    }

}