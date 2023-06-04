<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;

class Login extends Controller
{
    public function index()
    {
        $this->view('login');
    }
}