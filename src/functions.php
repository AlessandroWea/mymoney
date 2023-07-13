<?php

function dd($var)
{
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

function post($key, $default = '')
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}