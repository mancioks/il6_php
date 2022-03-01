<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../vendor/autoload.php';
include '../config.php';

session_start();

//use Controller;

if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] !== '/') {
    $path = trim($_SERVER['PATH_INFO'], '/');
    $path = explode('/', $path);

    $class = ucfirst($path[0]);
    if(isset($path[1])) {
        $method = $path[1];
    } else {
        $method = "index";
    }


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
            \Controller\Error::show(404);
        }

    }
    else {
        \Controller\Error::show(404);
    }

}
else {
    $obj = new \Controller\Home();
    $obj->index();
}