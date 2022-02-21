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
}