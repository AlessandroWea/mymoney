<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\models\User;

class Settings extends Controller
{
    public function index()
    {
        Auth::logged_in() ? true : $this->redirect('login');

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
            }

            if($_POST['email'] !== $_SESSION['USER']['email'])
            {
                $arr['email'] = $_POST['email'];
                $user->validateEmail($_POST['email']);
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