<!doctype html>
<html lang="lt">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Skelbimų ataskaita</title>

    <style type="text/css">
        @page {
            margin: 0px;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
        .invoice table {
            margin: 15px;
        }
        .invoice h3 {
            margin-left: 15px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
            padding: 50px;
            text-align: center;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        th{
            text-align: left;
        }
        .all td{
            font-weight: bold;
        }
        .all{
            background: #eee;
        }
    </style>

</head>
<body>

<div class="information">
Skelbimu portalas - skelbimu ataskaita
</div>


<br/>

<div class="invoice">
    <h3>Skelbimu ataskaita</h3>
    <table width="100%">
        <thead>
        <tr>
            <th>Pavadinimas</th>
            <th>Kaina</th>
            <th>Metai</th>
            <th>Sukurimo data</th>
            <th>Aktyvus</th>
            <th>Perziuros</th>
            <th>Vartotojas</th>
        </tr>
        </thead>
        <tbody>
        <?php if($this->data["ads"]): ?>
            <?php
            /**
             * @var \Model\Ad $ad
             */
            ?>
            <?php foreach($this->data["ads"] as $ad): ?>
                <tr>
                    <td><?= $ad->getTitle(); ?></td>
                    <td><?= $ad->getPrice(); ?>€</td>
                    <td><?= $ad->getYear(); ?></td>
                    <td><?= $ad->getCreatedAt(); ?></td>
                    <td><?= $ad->getActive(); ?></td>
                    <td><?= $ad->getViews(); ?></td>
                    <td><?= $ad->getUser()->getName(); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr class="all">
            <td>Viso:</td>
            <td><?= $this->data["price_count"] ?>€</td>
            <td></td>
            <td></td>
            <td></td>
            <td><?= $this->data["views_count"] ?></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>