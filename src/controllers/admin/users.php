<?php

namespace Alewea\Mymoney\controllers\admin;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Pager;
use Alewea\Mymoney\models\Account;
use Alewea\Mymoney\models\User;

class Users extends Controller
{
    public function runBefore()
    {
        // if(!Auth::isAdmin())
        //     $this->redirect('main');
    }
    public function index()
    {
        $user = new User;
        $pager = new Pager(2);
        $user->limit = 2;
        $user->offset = $pager->offset;
        $search = '';

        if(!empty($_GET['search']))
        {
            $search = $_GET['search'];
            $rows = $user->search(['username'], $search);
        }
        else
        {
            $rows =  $user->findAll();
        }

        $this->view('admin/users/index', [
            'page_name' => 'users',
            'search' => $search,
            'rows' => $rows,
            'pager' => $pager,
        ]);
    }

    public function add()
    {
        $user = new User;
        $account = new Account;
        if($this->isPost())
        {
            if($user->validate($_POST))
            {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                //adding a new user to the database
                $user_id = $user->add($_POST);

                // create the first account for a new user
                $account->add([
                    'name' => 'main',
                    'user_id' => $user_id,
                    'value' => 0,
                ]);

                $this->redirect('admin/users');
            }
        }

        $this->view('admin/users/add', [
            'page_name' => 'add user',
            'errors' => $user->errors,
        ]);
    }

    public function ban(int $id)
    {
        $user = new User;
        $user->update($id, ['banned' => 1]);
        $this->redirect('admin/users');
    }

    public function unban(int $id)
    {
        $user = new User;
        $user->update($id, ['banned' => 0]);
        $this->redirect('admin/users');
    }
}