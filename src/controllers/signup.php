<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\User;
use Alewea\Mymoney\core\Auth;

class Signup extends Controller
{
    public function index()
    {
        $user = new User();
        $account = new Account();

        if($this->isPost())
        {
            //validate the data
            if($user->validate($_POST)) //everything is valid
            {
                //encrypt password
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                //adding a new user to the database
                $_POST['role'] = Auth::$USER;
                $user_id = $user->add($_POST);

                // create the first account for a new user
                $account->add([
                    'name' => 'main',
                    'user_id' => $user_id,
                    'value' => 0,
                ]);

                //redirect
                $this->redirect('login');
            }
        }

        $this->view('signup', [
            'errors' => $user->errors,
            'page_name' => 'signup',
        ]);

    }


}