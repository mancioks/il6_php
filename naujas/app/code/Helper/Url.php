<?php

declare(strict_types=1);

namespace Helper;

use Controller\Catalog;
use Model\Ad;

class Url
{
    public static function redirect(string $route): void
    {
        header('Location: '.BASE_URL.$route);
        exit();
    }

    public static function link(string $path, ?string $param = null): string
    {
        $link = BASE_URL;
        $link .= $path;
        if(!str_ends_with($path, "/"))
            $link .= "/";
        if($param !== null)
            $link .= $param;

        return $link;
    }

    public static function generateSlug(string $title): string
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