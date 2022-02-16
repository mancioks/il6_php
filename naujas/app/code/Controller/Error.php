<?php

namespace Controller;

use Core\AbstractController;

class Error extends AbstractController
{
    public static function show($type = 404)
    {
        $object = new static();
        $object->render("parts/".$type);
    }
}