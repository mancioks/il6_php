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
    <link rel="stylesheet" href="<?php echo Url::link("css", "style.css"); ?>">
</head>
<body>
<header>
    <nav>
        <div class="inner-wrapper">
            <ul>
                <li><a href="/">Home page</a></li>
                <li><a href="/catalog/">Catalog</a></li>

                <?php if (!$this->isUserLogged()): ?>
                    <li class="float-right"><a href="/user/register">Sign up</a></li>
                    <li class="float-right"><a href="/user/login">Login</a></li>
                <?php endif; ?>

                <?php if ($this->isUserLogged()): ?>
                    <li><a href="/catalog/create">Create ad</a></li>
                    <li><a href="/user/">Users</a></li>
                    <li class="float-right">
                        <a href="/user/logout" class="log-out">Log out</a>
                    </li>
                <?php endif; ?>

            </ul>
            <div class="search-wrapper">
                <form action="<?php echo BASE_URL; ?>catalog/results/" method="GET">
                    <input type="text" name="search" placeholder="Paieška">
                    <button type="submit">Ieškoti</button>
                </form>
            </div>
        </div>
    </nav>
</header>
<div class="inner-wrapper main-content">