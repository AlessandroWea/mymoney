<?php

namespace Alewea\Mymoney\core;

class App
{
    public string $default_controller = 'main';
    public string $default_method = 'index';

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];

        $parts = explode('/',$uri);
        array_shift($parts);

        $controller_name = $this->default_controller;
        $method_name = $this->default_method;

        if($parts[0] != ''){
            if(count($parts) < 2){
                $controller_name = array_shift($parts);
            }else {
                $controller_name = array_shift($parts);
                $method_name = array_shift($parts);
            }

        }

        try
        {
            $reflectionObject = new \ReflectionClass('Alewea\Mymoney\controllers\\' . $controller_name);
            $object = $reflectionObject->newInstanceArgs();
            $method = $reflectionObject->getMethod($method_name);
            return $method->invokeArgs($object, $parts);
        }
        catch(\ReflectionException $e)
        {
            echo '<h1>404 Not found</h1>';
            echo '<p>' . $e->getMessage() . '</p>';
            //show 404 error page
            die;
        }

    }
}