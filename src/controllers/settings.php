<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\models\User;

class Settings extends Controller
{
    public function runBefore()
    {
        Auth::logged_in() ? true : $this->redirect('login');
    }

    public function index()
    {
        $arr = [];
        $errors = [];
        $user = new User;
        $row = $user->first(['id' => $_SESSION['USER']['id']]);
        if($this->isPost())
        {
            if($_POST['username'] !== $_SESSION['USER']['username'])
            {
                $arr['username'] = $_POST['username'];
                $user->validateUsername($_POST['username']);
                $user->exists('username', $_POST['username'], 'Username is already taken');
            }

            if($_POST['email'] !== $_SESSION['USER']['email'])
            {
                $arr['email'] = $_POST['email'];
                $user->validateEmail($_POST['email']);
                $user->exists('email', $_POST['email'], 'Email is already taken');
            }

            // if changing password
            if(!empty($_POST['password']))
            {
                $arr['password'] = $_POST['password'];
                $user->validatePassword($_POST['password'], $_POST['password2']);
                $arr['password'] = password_hash($arr['password'], PASSWORD_DEFAULT);
            }

            if(empty($user->errors))
            {
                $user->update($_SESSION['USER']['id'], $arr);
                $_SESSION['USER'] = $user->first(['id' => $_SESSION['USER']['id']]);;
                $this->redirect('settings');
            }
            $errors = $user->errors;
        }

        $this->view('settings', [
            'page_name'=>'settings',
            'username' => $row['username'],
            'email' => $row['email'],
            'errors' => $errors,
        ]);
    }
}