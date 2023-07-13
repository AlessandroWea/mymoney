<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class User extends Model
{
    static protected string $tableName = 'users';

    public array $errors = [];

    public function validate($data)
    {
        $this->errors = [];

        if(empty($data['username']))
        {
            $this->errors['username'] = 'Username must not be empty';
        }
        else if(strlen($data['username']) < 4)
        {
            $this->errors['username'] = 'Username must ccntain more than 4 chars';
        }

        if(empty($data['email']))
        {
            $this->errors['email'] = 'Email must not be empty';
        }
        else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
        {
            $this->errors['email'] = 'Email is invalid';
        }

        if(empty($data['password']))
        {
            $this->errors['password'] = 'Password must not be empty';
        }
        else if(strlen($data['password']) < 6)
        {
            $this->errors['password'] = 'Password is too short (6 min)';
        }
        else if($data['password'] !== $data['password2'])
        {
            $this->errors['password'] = 'Passwords do not match!';
        } 

        return empty($this->errors) ? true : false;
    }

    public function sign_up()
    {

    }
}
