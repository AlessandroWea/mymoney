<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Model;
use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\Category;
use Alewea\Mymoney\models\Operation;

class Main extends Controller
{
    public function index()
    {
        Auth::logged_in() ? true : $this->redirect('login');
        
        $operation = new Operation();

        $current_date = date('Y-m-d');

        $data = $operation->get_with_category($_SESSION['ACTIVE_ACCOUNT']['id'], $current_date);

        $this->view('main', [
            'rows' => $data,
        ]);
    }

    public function add()
    {
        $operation = new Operation();
        $account = new Account();
        $category = new Category();

        if($this->isPost())
        {
            if($operation->validate($_POST))
            {
                $_POST['date'] = date('Y-m-d');
                $_POST['account_id'] = $_SESSION['ACTIVE_ACCOUNT']['id'];

                $operation->add($_POST);
                $category_row = $category->first(['id'=>$_POST['category_id']]);
                if($category_row['type'] == Category::$TYPE_INCOME)
                {
                    $_SESSION['ACTIVE_ACCOUNT']['value'] += $_POST['value'];
                }
                else
                {
                    $_SESSION['ACTIVE_ACCOUNT']['value'] -= $_POST['value'];
                }

                $account->update($_SESSION['ACTIVE_ACCOUNT']['id'], [
                    'value' => $_SESSION['ACTIVE_ACCOUNT']['value'],
                ]);
                
                $this->redirect('main');
            }
        }

        $this->view('main-add', [
            'errors' => $operation->errors,
        ]);
    }
}