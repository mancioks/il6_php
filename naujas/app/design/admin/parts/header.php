<?php

use Helper\Url;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $this->data["title"]; ?></title>
    <meta name="description" content="<?php echo $this->data["meta_description"]; ?>">
    <link rel="stylesheet" href="<?php echo Url::link("css", "admin.css"); ?>">
</head>
<body>
<header>
    <nav>
        <div class="inner-wrapper">
            <ul>
                <li><a href="/admin">Pradžia</a></li>
                <li><a href="/admin/users">Vartotojai</a></li>
                <li><a href="/admin/ads">Skelbimai</a></li>
                <li><a href="/admin/reports">Ataskaitos</a></li>
                <li class="float-right">
                    <a href="/user/logout" class="button log-out">Atsijungti</a>
                </li>
                <li class="float-right">
                    <a href="/" class="button admin-exit">Išeiti iš administravimo</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="inner-wrapper main-content">