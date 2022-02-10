<?php

namespace Helper;

class Url
{
    public static function redirect($route) {
        header('Location: '.BASE_URL.$route);
        exit();
    }

    public static function link($path, $param = null)
    {
        $link = BASE_URL;
        $link .= $path;
        if(!str_ends_with($path, "/"))
            $link .= "/";
        if($param !== null)
            $link .= $param;

        return $link;
    }
}