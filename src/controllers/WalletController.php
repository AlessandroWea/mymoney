<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Database;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\Operation;
use Alewea\Mymoney\models\Permission;
use Alewea\Mymoney\models\User;

class WalletController extends Controller
{
    public function runBefore()
    {
        // (new Database())->create_permissions_table();
        Auth::logged_in() ? true : $this->redirect('login');
    }

    public function actionIndex(int $id = null)
    {
        $viewmode = 0;
        $viewId = $_SESSION['USER']['id'];
        $guestUsername = '';
        $permissionModel = new Permission();
        $userModel = new User();
        //viewmodee
        if($id != null)
        {
            $viewmode = 1;
            //check if the user has a permission to watch this
            $permission = $permissionModel->first([
                'user1_id' => $_SESSION['USER']['id'],
                'user2_id' => $id,
                'permission' => Permission::WALLET_PERMISSION,
            ]);

            if($permission['active'] != 1)
            {
                $this->redirect('wallet');
            }

            $viewId = $id;
            $guestUsername = $userModel->getUsername($id);
        }

        $account = new Account();
        $accounts = $account->where([
            'user_id' => $viewId,
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
            'viewmode' => $viewmode,
            'guestUsername' => $guestUsername,
        ]);
    }

    public function actionAdd()
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

    public function actionEdit($id = null)
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

    public function actionDelete($id = null)
    {
        $account = new Account();
        $row = $account->first([
            'id' => $id,
            'user_id' => $_SESSION['USER']['id'],
        ]);

        if(!$row) $this->redirect('wallet');

        if($this->isPost())
        {
            try {
                Database::beginTransaction();
                $account->delete($id);
                $operation = new Operation;
                $operation->deleteBy('account_id', $id);
                Database::commit();
            }
            catch(\PDOException $e)
            {
                Database::rollBack();
                throw $e; // ^_^
            }
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

    public function actionSwitch($id = null)
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