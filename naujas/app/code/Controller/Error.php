<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;

class Error extends AbstractController implements ControllerInterface
{
    public function index()
    {

    }

    public static function show($type = 404, $admin = false)
    {
        $object = new static();
        if(!$admin) {
            $object->render("parts/".$type);
        } else {
            $object->renderAdmin("parts/".$type);
        }
    }
}