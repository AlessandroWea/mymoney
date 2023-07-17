<?php

namespace Alewea\Mymoney\core;

class Auth
{
    public static int $ADMIN = 1;
    public static int $USER = 0;
    
    public static function logged_in() : bool
    {
        return isset($_SESSION['USER']);
    }

    public static function is_admin() : bool
    {
        if(Auth::logged_in() && $_SESSION['USER']['role'] == Auth::$ADMIN)
        {
            return true;
        }

        return false;
    }
}