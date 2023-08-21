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

function path($path)
{
    return '/' . $path;
}

function selected($key, $val)
{
    if(isset($_POST[$key]) && $_POST[$key] == $val)
    {
        return ' selected ';
    }

    return '';
}