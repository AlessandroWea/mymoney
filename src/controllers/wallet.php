<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Account;

class Wallet extends Controller
{
    public function index()
    {
        Auth::logged_in() ? true : $this->redirect('login');

        $account = new Account();
        $accounts = $account->where([
            'user_id' => $_SESSION['USER']['id'],
        ]);
        
        $net = 0;
        foreach($accounts as $account)
        {
            $net += $account['value'];
        }

        $this->view('wallet/index', [
            'accounts' => $accounts,
            'net' => $net,
            'page_name' => 'wallet',
        ]);
    }

    public function add()
    {
        Auth::logged_in() ? true : $this->redirect('login');

        $errors = [];
        $account = new Account();

        if($this->isPost())
        {
            if($account->validate($_POST))
            {
                $_POST['user_id'] = $_SESSION['USER']['id'];
                $account->add($_POST);

                $this->redirect('wallet');
            }

            $errors = $account->errors;
        }

        $this->view('wallet/add', [
            'errors' => $errors,
        ]);
    }

    public function edit($id = null)
    {
        Auth::logged_in() ? true : $this->redirect('login');

        if(empty($id) || !is_numeric($id))
        {
            $this->redirect('wallet');
        }
        $errors = [];
        $account = new Account();
        $row = $account->first([
            'id' => $id,
        ]);

        if($this->isPost())
        {
            if($account->validate($_POST))
            {
                $account->update($id, $_POST);
                $this->redirect('wallet');
            }

            $errors = $account->errors;
        }

        $this->view('wallet/edit', [
            'row' => $row,
            'errors' => $errors,
        ]);
    }

    public function delete($id = null)
    {
        Auth::logged_in() ? true : $this->redirect('login');

        if(empty($id) || !is_numeric($id))
        {
            $this->redirect('wallet');
        }

        $account = new Account();
        $row = $account->first([
            'id' => $id,
        ]);

        if($this->isPost())
        {
            $account->delete($id);
            $this->redirect('wallet');
        }

        $this->view('wallet/delete', [
            'row' => $row,
        ]);
    }

    public function switch($id = null)
    {
        Auth::logged_in() ? true : $this->redirect('login');

        if(empty($id) || !is_numeric($id))
        {
            $this->redirect('wallet');
        }

        $account = new Account;
        $row = $account->first([
            'id' => $id,
            'user_id' => $_SESSION['USER']['id'],
        ]);

        if($row)
        {
            $_SESSION['ACTIVE_ACCOUNT'] = $row;
        }

        $this->redirect('wallet');
    }
}