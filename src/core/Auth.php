<?php

namespace Alewea\Mymoney\core;

class Auth
{
    const USER = 0;
    const ADMIN = 1;
    
    public static function logged_in() : bool
    {
        return isset($_SESSION['USER']);
    }

    public static function isAdmin(): bool
    {
        if(isset($_SESSION['USER']) && $_SESSION['USER']['role'] == self::ADMIN)
            return true;
        
        return false;
    }

}