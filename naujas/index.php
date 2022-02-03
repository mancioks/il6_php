<?php

include 'vendor/autoload.php';
include 'config.php';

session_start();

//use Controller;

if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {
    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);

    $class = ucfirst($path[0]);
    $method = $path[1];


    $class = 'Controller\\'.$class;
    if(class_exists($class)) {
        $object = new $class();

        if(method_exists($object, $method)) {
            if(isset($path[2])) {
                $object->$method($path[2]);
            }
            else {
                $object->$method();
            }

        }
        else {
            echo "404";
        }

    }
    else {
        echo "404";
    }

}
else {
    echo "<h1>Titulinis</h1>";
    print_r($_SESSION);
}