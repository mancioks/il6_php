<?php

namespace Model;

class Session
{
    private $sessionName;

    public function get($name = null)
    {
        if($name && isset($_SESSION[$name]))
            return $_SESSION[$name];
        return false;
    }
    public function set($name) {
        $this->sessionName = $name;
        return $this;
    }
    public function value($value)
    {
        if($this->sessionName) {
            $_SESSION[$this->sessionName] = $value;
            return true;
        } else {
            return false;
        }
    }
    public function add($value)
    {
        if($this->sessionName && is_array($_SESSION[$this->sessionName])) {
            $_SESSION[$this->sessionName][] = $value;
            return true;
        } else {
            return false;
        }
    }
}