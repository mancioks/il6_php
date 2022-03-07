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
                <li><a href="/">Pradžia</a></li>
                <li><a href="/catalog/">Visi skelbimai</a></li>

                <?php if (!$this->isUserLogged()): ?>
                    <li class="float-right"><a href="/user/register">Registruotis</a></li>
                    <li class="float-right"><a href="/user/login">Prisijungti</a></li>
                <?php endif; ?>

                <?php if ($this->isUserLogged()): ?>
                    <li><a href="/catalog/create">Pridėti</a></li>
                    <li><a href="/catalog/myads">Mano skelbimai</a></li>
                    <li>
                        <a href="/inbox" <?php if($this->data["new_messages"] > 0) echo ' class="inbox-new-messages"'; ?>'>
                            Žinutės <?php if($this->data["new_messages"] > 0) echo "(".$this->data["new_messages"].")"; ?>
                        </a>
                    </li>
                    <li class="float-right">
                        <a href="/user/logout" class="button log-out">Atsijungti</a>
                    </li>
                <?php endif; ?>

                <?php if ($this->isUserAdmin()): ?>
                    <li class="float-right">
                        <a href="/admin" class="button admin-button">Admin</a>
                    </li>
                <?php endif; ?>
                <li>
                    <div class="search-wrapper">
                        <form action="<?php echo BASE_URL; ?>catalog/results/" method="GET">
                            <input type="text" name="search" placeholder="Paieška">
                            <button type="submit">Ieškoti</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="inner-wrapper main-content">