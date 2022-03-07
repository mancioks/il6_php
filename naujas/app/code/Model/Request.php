<?php

namespace Model;

class Request
{
    public function post($name = null)
    {
        if($name && isset($_POST[$name]))
            return $_POST[$name];
        return false;
    }

    public function get($name = null)
    {
        if($name && isset($_GET[$name]))
            return $_GET[$name];
        return false;
    }
}