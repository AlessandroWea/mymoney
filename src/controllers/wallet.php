<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\models\Account;

class Wallet extends Controller
{
    public function runBefore()
    {
        Auth::logged_in() ? true : $this->redirect('login');
    }

    public function index()
    {
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
        $errors = [];
        $account = new Account();

        if($this->isPost())
        {
            if($account->validate($_POST))
            {
                $_POST['user_id'] = $_SESSION['USER']['id'];
                $account->add($_POST);

                // switch to a new account if there were none before
                if(empty($_SESSION['ACTIVE_ACCOUNT']))
                {
                    $_SESSION['ACTIVE_ACCOUNT']= $account->first([
                        'user_id' => $_SESSION['USER']['id'],
                    ]);
                }

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
        $errors = [];
        $account = new Account();
        $row = $account->first([
            'id' => $id,
            'user_id' => $_SESSION['USER']['id'],
        ]);

        // account wasnnot found
        if(!$row) $this->redirect('wallet');

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
        $account = new Account();
        $row = $account->first([
            'id' => $id,
            'user_id' => $_SESSION['USER']['id'],
        ]);

        if(!$row) $this->redirect('wallet');

        if($this->isPost())
        {
            $account->delete($id);

            // find an account to switch to
            $new = $account->first([
                'user_id' => $_SESSION['USER']['id'],
            ]);

            // there is an account available
            if($new)
            {
                $_SESSION['ACTIVE_ACCOUNT'] = $new;
            }
            else // there is no accounts left
            {
                $_SESSION['ACTIVE_ACCOUNT'] = [];
            }

            $this->redirect('wallet');
        }

        $this->view('wallet/delete', [
            'row' => $row,
        ]);
    }

    public function switch($id = null)
    {
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