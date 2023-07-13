<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\User;

class Signup extends Controller
{
    public function index()
    {
        $user = new User();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //validate the data
            if($user->validate($_POST)) //everything is valid
            {
                //encrypt password
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                //sign up
                $user->sign_up($_POST);

                //redirect
                $this->redirect('login');
            }
        }

        $this->view('signup', [
            'errors' => $user->errors,
        ]);

    }


}