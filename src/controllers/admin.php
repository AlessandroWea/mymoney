<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Pager;
use Alewea\Mymoney\models\Category;
use Alewea\Mymoney\models\User;

class Admin extends Controller
{
    public function runBefore()
    {
        // if(!Auth::isAdmin())
        //     $this->redirect('main');
    }
    public function users()
    {
        $user = new User;
        $pager = new Pager(2);
        $user->limit = 2;
        $user->offset = $pager->offset;

        $rows =  $user->findAll();
        $this->view('admin/users', [
            'page_name' => 'users',
            'rows' => $rows,
            'pager' => $pager,
        ]);
    }

    public function categories()
    {
        $category = new Category;
        $pager = new Pager(2);
        $category->limit = 2;
        $category->offset = $pager->offset;

        $rows =  $category->findAll();
        $this->view('admin/categories', [
            'page_name' => 'categories',
            'rows' => $rows,
            'pager' => $pager,
        ]);   
    }
}