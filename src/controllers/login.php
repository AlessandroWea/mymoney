<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\User;

class Login extends Controller
{
    public function index()
    {
        $user = new User();
        $account = new Account();
        $errors = '';

        if($this->isPost())
        {
            // if user supplied all the data
            if(!empty($_POST['username']) && !empty($_POST['password']))
            {
                // look for an existing row in the database
                $user_row = $user->first(['username'=>$_POST['username']]);
                if($user_row)
                {
                    if(password_verify($_POST['password'], $user_row['password']))
                    {
                        if(!$user_row['banned'])
                        {
                            $_SESSION['USER'] = $user_row;
                            //finds the first user's account and makes it the main one
                            $_SESSION['ACTIVE_ACCOUNT'] = $account->first([
                                'user_id' => $user_row['id'],
                            ]);
                            $this->redirect('main');
                        }
  
                        $this->redirect('login');
                    }
                }
            }
            $errors = 'Incorrect username or password';
        }

        $this->view('login', [
            'errors' => $errors,
            'page_name' => 'login'
        ]);
    }
}