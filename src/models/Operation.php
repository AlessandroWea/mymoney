<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Operation extends Model
{
    static protected string $tableName = 'operations';
    static public array $enabledCols = ['category_id', 'account_id', 'comment' ,'value', 'date'];

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

        if(!empty($data['comment']) && strlen($data['comment']) > 128)
        {
            $this->errors['comment'] = 'Comment is too long!';
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
                      operations.date = :date
                LIMIT ' . $this->limit . ' OFFSET ' . $this->offset;

        $ret = $this->query($sql, [
            'account_id' => $account_id,
            'date' => $date
        ]);

        return $ret->fetchAll();
    }

    public function get_total_value_by_categories($account_id, $type, $start_date = '', $end_date = '')
    {
        if($start_date == '' && $end_date == '')
        {
            $sql = "SELECT categories.name AS category, SUM(value) as value
                    FROM operations
                    JOIN categories
                    ON operations.category_id = categories.id
                    WHERE account_id = :account_id AND
                        type = :type 
                    GROUP BY category;
            ";

            $ret = $this->query($sql, [
                'account_id' => $account_id,
                'type' => $type,
            ]);
        }
        else
        {
            $sql = "SELECT categories.name AS category, SUM(value) as value
                    FROM operations
                    JOIN categories
                    ON operations.category_id = categories.id
                    WHERE account_id = :account_id AND
                        date >= :start_date AND
                        date < :end_date AND 
                        type = :type 
                    GROUP BY category;
            ";

            $ret = $this->query($sql, [
                'account_id' => $account_id,
                'type' => $type,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
        }

        return $ret->fetchAll();
    }
}