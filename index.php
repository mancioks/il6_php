<?php
$products = [
    [
        'name' => 'Siulai',
        'price' => 12.4,
        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
    ],
    [
        'name' => 'adata',
        'price' => 1.99,
        'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'
    ],
    [
        'name' => 'virbalai',
        'price' => 3.99,
        'special_price' => 2.49,
        'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'
    ],
    [
        'name' => 'Siulai',
        'price' => 12.4,
        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
    ],
    [
        'name' => 'adata',
        'price' => 1.99,
        'special_price' => 0.99,
        'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'
    ],
    [
        'name' => 'virbalai',
        'price' => 3.99,
        'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'
    ],
    [
        'name' => 'Siulai',
        'price' => 12.4,
        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
    ],
    [
        'name' => 'adata',
        'price' => 1.99,
        'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'
    ],
    [
        'name' => 'virbalai',
        'price' => 3.99,
        'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'
    ],
    [
        'name' => 'Siulai',
        'price' => 12.4,
        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
    ],
    [
        'name' => 'adata',
        'price' => 1.99,
        'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'
    ],
    [
        'name' => 'virbalai',
        'price' => 3.99,
        'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'
    ],
    [
        'name' => 'Siulai',
        'price' => 12.4,
        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
    ],
    [
        'name' => 'adata TEST',
        'price' => 1.99,
        'img' => 'https://www.vle.lt/uploads/_CGSmartImage/70839_3-26c56fce05f1ac6e0247f6daa86648aa.jpg'
    ],
    [
        'name' => 'virbalai',
        'price' => 3.99,
        'img' => 'https://mezgimomanija.lt/wp-content/uploads/2019/02/3397.jpg'
    ],
];

$count = 0;

foreach($products as $product){

    $count++;

    $productPrice = $product["price"];
    if(isset($product["special_price"])) {
        $productPrice = "<del>".$productPrice."</del> ". $product["special_price"];
    }

    echo '<img width="60" src="'. $product['img'] .'"/>';
    echo '<h2>'. $product["name"] . '</h2>';
    echo '<h3>'. $productPrice . '</h3>';
    if($count % 3 == 0) {
        echo '<hr>';
    }

}