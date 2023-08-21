<?php

namespace Alewea\Mymoney\models;

use Alewea\Mymoney\core\Model;

class User extends Model
{
    static protected string $tableName = 'users';
    static public array $enabledCols = ['username', 'email', 'password', 'role'];

    public array $errors = [];

    public function validate($data)
    {
        $this->errors = [];

        $this->validateUsername($data['username']);
        $this->exists('username', $data['username'], 'Username is already taken');
        $this->validateEmail($data['email']);
        $this->exists('email', $data['email'], 'Email is already taken');
        $this->validatePassword($data['password'], $data['password2']);

        return empty($this->errors) ? true : false;
    }

    public function exists($field, $value, $errMsg = '')
    {
        if($this->first([$field => $value]))
        {
            $this->errors[$field] = $errMsg;
        }
    }

    public function validateUsername($username = '')
    {
        if(empty($username))
        {
            $this->errors['username'] = 'Username must not be empty';
        }
        else if(strlen($username) < 4)
        {
            $this->errors['username'] = 'Username must ccntain more than 4 chars';
        }
    }

    public function validateEmail($email = '')
    {
        if(empty($email))
        {
            $this->errors['email'] = 'Email must not be empty';
        }
        else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->errors['email'] = 'Email is invalid';
        }
    }

    public function validatePassword($password = '', $password2 = '')
    {

        if(empty($password))
        {
            $this->errors['password'] = 'Password must not be empty';
        }
        else if(strlen($password) < 6)
        {
            $this->errors['password'] = 'Password is too short (6 min)';
        }
        else if($password !== $password2)
        {
            $this->errors['password'] = 'Passwords do not match!';
        } 
    
    }
}
