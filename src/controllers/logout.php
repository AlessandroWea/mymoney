<?php

namespace Alewea\Mymoney\controllers;

use Alewea\Mymoney\core\Controller;

class Logout extends Controller
{
    public function index()
    {
        session_unset();
        session_destroy();

        $this->redirect('login');
    }
}