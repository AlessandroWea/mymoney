<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class Account extends Model
{
    static protected string $tableName = 'accounts';
    static public array $enabledCols = ['name', 'user_id', 'value'];

    public array $errors = [];

    public function validate($data)
    {
        $this->errors = [];

        if(empty($data['name']))
        {
            $this->errors['name'] = 'Name must not be empty';
        }

        return empty($this->errors) ? true : false;
    }

    public function update_value_plus($account_id, $value)
    {
        $sql = "UPDATE accounts SET value = value + :value WHERE id = :account_id";

        $ret = $this->query($sql, [
            'account_id' => $account_id,
            'value' => $value,
        ]);

        return $ret;
    }

    public function update_value_minus($account_id, $value)
    {
        $sql = "UPDATE accounts SET value = value - :value WHERE id = :account_id";

        $ret = $this->query($sql, [
            'account_id' => $account_id,
            'value' => $value,
        ]);

        return $ret;
    }

}
