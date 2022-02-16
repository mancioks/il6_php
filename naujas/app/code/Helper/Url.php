<?php

namespace Helper;

use Controller\Catalog;
use Model\Ad;

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

    public static function generateSlug($title)
    {

        $slug = $title;

        // replace non letter or digits by divider
        $slug = preg_replace('~[^\pL\d]+~u', "-", $slug);

        // remove unwanted characters
        $slug = preg_replace('~[^-\w]+~', '', $slug);

        // trim
        $slug = trim($slug, "-");

        // remove duplicate divider
        $slug = preg_replace('~-+~', "-", $slug);

        $slug = strtolower($slug);

        return $slug;
    }
}