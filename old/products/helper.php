<?php

const URL = 'http://localhost/pamokos-php/products/';

function readFromCsv($fileName)
{
    $data = [];
    $fh = fopen($fileName, 'r');

    while (!feof($fh)) {
        $line = fgetcsv($fh);
        if (!empty($line)) {
            $data[] = $line;
        }
    }

    fclose($fh);
    return $data;
}

function prepareProducts($products)
{
    $header = $products[0];
    unset($products[0]);

    $data = [];

    foreach ($products as $product) {
        $data[] = [
            $header[0] => $product[0],
            $header[1] => $product[1],
            $header[2] => $product[2],
            $header[3] => $product[3],
            $header[4] => $product[4],
        ];
    }

    return $data;
}

function debug($data)
{
    echo "<pre>";
    var_dump($data);
    die();
}

function canAddToCart($product)
{
    if ($product["qty"] > 0) {
        return true;
    }
    return false;
}

function getProductUrl($id)
{
    return URL . 'product.php?id=' . $id;
}

function getProductById($id) {
    $products = prepareProducts(readFromCsv("products10-03-2021.csv"));

    foreach ($products as $product) {
        if($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

function addProduct($product){
    $file = fopen("products10-03-2021.csv", 'a');

    foreach ($product as $element) {
        fputcsv($file, $element);
    }

    fclose($file);
}