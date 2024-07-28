<?php

namespace Alewea\Mymoney\core;

class App
{
    public string $default_controller = 'MainController';
    public string $default_method = 'actionIndex';

    public function run()
    {
        $uri = $_SERVER['REQUEST_URI'];
        $is_json = false;
        if(isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/json')
            $is_json = true;
        // dd($_SERVER['HTTP_HEADERS']);die;
        $uri = explode('?', $uri)[0];
        $parts = explode('/',$uri);
        array_shift($parts);
        $module = '';
        $controller_name = $this->default_controller;
        $method_name = $this->default_method;
        if($parts[0] != ''){
            if($parts[0] == 'admin'){
                $module = 'admin\\';
                array_shift($parts);
            }

            if(count($parts) < 2){
                $controller_name = ucfirst(array_shift($parts));
            }else {
                $controller_name = ucfirst(array_shift($parts));
                $method_name = 'action' . ucfirst(array_shift($parts));
            }
            $controller_name .= 'Controller';

        }
        try
        {
            // dd(class_exists('Alewea\Mymoney\controllers\\' . $controller_name) ?? 'doesnt');
            $reflectionObject = new \ReflectionClass('Alewea\Mymoney\controllers\\' . $module . $controller_name);
            $object = $reflectionObject->newInstanceArgs();
            $method = $reflectionObject->getMethod($method_name);

            if(method_exists($object, 'runBefore'))
            {
                $beforeMethod = $reflectionObject->getMethod('runBefore');
                $beforeMethod->invokeArgs($object, [['method' => $method_name]]);
            }

            return $method->invokeArgs($object, $parts ?? []);
        }
        catch(\ReflectionException $e)
        {
            if($is_json)
            {
                header('Content-type: application/json');

                echo json_encode(['error' => $e->getMessage()]);  
            }
            else
            {
                echo '<h1>404 Not found</h1>';
                echo '<p>' . $e->getMessage() . '</p>';
                //show 404 error page
                die;              
            }

        }
        catch(\Error $er)
        {

            if($is_json)
            {
                header('Content-type: application/json');

                echo json_encode(['error' => $e->getMessage()]);  
            }
            else
            {
                echo '<h1>404 Not found</h1>';
                echo '<p>' . $e->getMessage() . '</p>';
                //show 404 error page
                die;              
            }
        }

    }
}