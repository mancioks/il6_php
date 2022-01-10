<?php
include_once "helper.php";

$id = $_GET["id"];
$product = getProductById($id);

debug($product);