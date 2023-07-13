<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;
use Alewea\Mymoney\core\Model;

class Main extends Controller
{
    public function index()
    {
        $data = [
            'rows' => [
                [
                    'type' => 'income',
                    'category' => 'salary',
                    'value' => '30000'
                ]
            ],
        ];

        $model = new Model();
        // $row = $model->first([
        //     'name' => 'main',
        //     'balance' => '1000'
        // ]);

        $this->view('main', $data);
    }
}