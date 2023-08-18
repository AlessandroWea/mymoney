<?php

namespace Alewea\Mymoney\core;

class Auth
{
    public static int $USER = 0;
    
    public static function logged_in() : bool
    {
        return isset($_SESSION['USER']);
    }

}