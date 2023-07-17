<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Operation extends Model
{
    static protected string $tableName = 'operations';
    static public array $enabledCols = ['category_id', 'account_id', 'value', 'date'];

    public array $errors = [];

    public function validate($data)
    {
        $this->errors = [];

        if(empty($data['category_id']))
        {
            $this->errors['category_id'] = 'Choose a category';
        }

        if(empty($data['value']))
        {
            $this->errors['value'] = 'Enter a value';
        }

        return empty($this->errors) ? true : false;
    }

    public function get_with_category($account_id, $date)
    {
        $sql = 'SELECT operations.*, categories.type, categories.name AS category_name
                FROM operations
                JOIN categories
                ON operations.category_id = categories.id
                WHERE operations.account_id = :account_id AND
                      operations.date = :date';

        $ret = $this->query($sql, [
            'account_id' => $account_id,
            'date' => $date
        ]);

        return $ret->fetchAll();
    }
}