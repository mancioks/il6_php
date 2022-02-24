<?php

namespace Controller;

use Core\AbstractController;

class Error extends AbstractController
{
    public static function show($type = 404, $admin = false)
    {
        $object = new static();
        if(!$admin) {
            $object->render("parts/".$type);
        } else {
            $object->renderAdmin("parts/".$type);
        }
    }

    public static function store($message) {
        if(!isset($_SESSION["errors"])) {
            $_SESSION["errors"] = [];
        }

        $_SESSION["errors"][] = $message;
    }

    public static function hasErrors()
    {
        if(!isset($_SESSION["errors"])) {
            $_SESSION["errors"] = [];
        }

        return !empty($_SESSION["errors"]);
    }

    public static function getErrors()
    {
        if(!isset($_SESSION["errors"])) {
            $_SESSION["errors"] = [];
        }

        $errors = $_SESSION["errors"];
        $_SESSION["errors"] = [];

        return !empty($errors) ? $errors : false;
    }
}