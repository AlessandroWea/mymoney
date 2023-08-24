<?php

namespace Alewea\Mymoney\controllers\admin;

use Alewea\Mymoney\core\Auth;
use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Pager;
use Alewea\Mymoney\models\Category;

class Categories extends Controller
{
    public function runBefore()
    {
        // if(!Auth::isAdmin())
        //     $this->redirect('main');
    }

    public function index()
    {
        $category = new Category;
        $pager = new Pager(2);
        $category->limit = 2;
        $category->offset = $pager->offset;
        $search = '';

        if(!empty($_GET['search']))
        {
            $search = $_GET['search'];
            $rows = $category->search(['name'], $search);
        }
        else
        {
            $rows =  $category->findAll();
        }

        $this->view('admin/categories/index', [
            'page_name' => 'categories',
            'search' => $search,
            'rows' => $rows,
            'pager' => $pager,
        ]);   
    }

    public function add()
    {
        $category = new Category;
        if($this->isPost())
        {
            if($category->validate($_POST))
            {
                $category->add($_POST);
                $this->redirect('admin/categories');
            }
        }

        $this->view('admin/categories/add', [
            'page_name' => 'Add category',
            'errors' => $category->errors,
        ]);
    }

    public function edit($id = null)
    {
        $category = new Category;
        $row = $category->first(['id'=>$id]);
        if(!$row) $this->redirect('admin/categories');

        if($this->isPost())
        {
            if($category->validate($_POST))
            {
                $category->update($id, $_POST);
                $this->redirect('admin/categories');
            }
        }
        
        $this->view('admin/categories/edit', [
            'row' => $row,
            'page_name' => 'edit category',
            'errors'=> $category->errors,
        ]);   
    }

    public function disable(int $id)
    {
        $category = new Category;
        $category->update($id, ['disabled' => 1]);

        $this->redirect('admin/categories');
    }

    public function enable(int $id)
    {
        $category = new Category;
        $category->update($id, ['disabled' => 0]);
        
        $this->redirect('admin/categories');
    }
}