<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;

class Main extends Controller
{
    public function index()
    {
        $this->view('main');
    }
}