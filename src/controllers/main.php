<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Pager;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\Category;
use Alewea\Mymoney\models\Operation;

class Main extends Controller
{
    public function runBefore($extra)
    {
        Auth::logged_in() ? true : $this->redirect('login');
        
        if(empty($_SESSION['ACTIVE_ACCOUNT']) && $extra['method'] !== 'index')
            $this->redirect('main');
    }

    public function index()
    {
        $operation = new Operation();
        $data = [];
        $date = $_SESSION['active_date'] ?? date('Y-m-d');

        if($this->isPost())
        {
            if(!empty($_POST['date']))
            {
                $date = $_POST['date'];
                $_SESSION['active_date'] = $date;
            }
        }

        $operation->limit = 5;
        $pager = new Pager($operation->limit);
        $operation->offset = $pager->offset;

        if(!empty($_SESSION['ACTIVE_ACCOUNT']))
        {
            $data = $operation->get_with_category($_SESSION['ACTIVE_ACCOUNT']['id'], $date);
        }

        // do not show pagination when there is definitely no other pages
        $is_show_pagination = (count($data) < $operation->limit) ? false : true;

        $end_date = date('Y-m-d', strtotime('+ 1 day', strtotime($date)));

        $total_income = $this->get_total_value(Category::$TYPE_INCOME, $date, $end_date);
        $total_expensis = $this->get_total_value(Category::$TYPE_EXPENSIS, $date, $end_date);

        $this->view('main/index', [
            'rows' => $data,
            'total_income' => $total_income,
            'total_expensis' => $total_expensis,
            'date' => $date,
            'page_name' => 'main',
            'pager' => $pager,
            'is_show_pagination' => $is_show_pagination,
        ]);
    }

    public function get_total_value($type, $start_date, $end_date)
    {
        $operation = new Operation;
        $rows = $operation->get_total_value_by_categories($_SESSION['ACTIVE_ACCOUNT']['id'], $type, $start_date, $end_date);
        $sum = 0;
        foreach($rows as $row)
        {
            $sum += $row['value'];
        }

        return $sum;
    }

    public function add()
    {
        $operation = new Operation();
        $account = new Account();
        $category = new Category();

        $income_categories = $category->where(['type' => Category::$TYPE_INCOME]);
        $expensis_categories = $category->where(['type' => Category::$TYPE_EXPENSIS]);

        $date = $_SESSION['active_date'] ?? date('Y-m-d');

        if($this->isPost())
        {
            if($operation->validate($_POST))
            {
                $_POST['date'] = $date;
                $_POST['account_id'] = $_SESSION['ACTIVE_ACCOUNT']['id'];

                $operation->add($_POST);
                $category_row = $category->first(['id'=>$_POST['category_id']]);
                if($category_row['type'] == Category::$TYPE_INCOME)
                {
                    $account->update_value_plus($_SESSION['ACTIVE_ACCOUNT']['id'], $_POST['value']);
                }
                else
                {
                    $account->update_value_minus($_SESSION['ACTIVE_ACCOUNT']['id'], $_POST['value']);
                }

                $this->redirect('main');
            }
        }
        $this->view('main/add', [
            'errors' => $operation->errors,
            'date' => $date,
            'income_categories' => $income_categories,
            'expensis_categories' => $expensis_categories,
            'page_name' => 'Add operation',
        ]);
    }

    public function edit($id = null)
    {
        $category = new Category;
        $account = new Account;
        $operation = new Operation;

        $errors = [];
        $income_categories = $category->where(['type' => Category::$TYPE_INCOME]);
        $expensis_categories = $category->where(['type' => Category::$TYPE_EXPENSIS]);

        $row = $operation->first(['id'=>$id, 'account_id' => $_SESSION['ACTIVE_ACCOUNT']['id']]);
        if($row)
        {
            if($this->isPost())
            {
                //update operation info and account's value accordinly
                if($operation->validate($_POST))
                {
                    $type = $category->first(['id'=>$row['category_id']])['type'];
                    $active_account = $account->first(['id'=>$_SESSION['ACTIVE_ACCOUNT']['id']]);
                    if($type == Category::$TYPE_INCOME)
                    {
                        $new_value = $active_account['value'] - $row['value'] + $_POST['value'];
                    } else
                    {
                        $new_value = $active_account['value'] + $row['value'] - $_POST['value'];
                    }

                    $account->update($active_account['id'], ['value' => $new_value]);
                    $operation->update($id, $_POST);

                    $this->redirect('main');
                }

                $errors = $operation->errors;
            }

            $this->view('main/edit', [
                'current_category_id' => $row['category_id'],
                'value' => $row['value'],
                'income_categories' => $income_categories,
                'expensis_categories' => $expensis_categories,
                'errors' => $errors,
            ]);
        }
        else
        {
            $this->redirect('main');
        }
    }

    public function delete($id = null)
    {
        $category = new Category;
        $account = new Account;
        $operation = new Operation;
    
        $row = $operation->first(['id'=>$id, 'account_id' => $_SESSION['ACTIVE_ACCOUNT']['id']]);
        if($row)
        {
            $type = $category->first(['id'=>$row['category_id']])['type'];
            $active_account = $account->first(['id'=>$_SESSION['ACTIVE_ACCOUNT']['id']]);
            if($type == Category::$TYPE_INCOME)
            {
                $new_value = $active_account['value'] - $row['value'] + $_POST['value'];
            } else
            {
                $new_value = $active_account['value'] + $row['value'] - $_POST['value'];
            }
    
            $account->update($active_account['id'], ['value' => $new_value]);
            $operation->delete($id);
        }
        
        $this->redirect('main');
    }
}