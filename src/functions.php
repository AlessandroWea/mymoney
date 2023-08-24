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

function get($key, $default = '')
{
    return isset($_GET[$key]) ? $_GET[$key] : $default;

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

function checked($key, $val, $default = null)
{
    if(isset($_POST[$key]) && $_POST[$key] == $val)
        return ' checked ';
    else if($default !== null && $val == $default)
        return ' checked ';

    return '';

}