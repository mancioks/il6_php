<?php

include_once "helper.php";

$products = prepareProducts(readFromCsv("products10-03-2021.csv"));

?>

<div class="products">
    <?php foreach ($products as $product) : ?>
        <div class="product">
            <img src="https://picsum.photos/id/<?php echo $product["id"]; ?>1/200/300"/>
            <h2>
                <?php echo $product["name"]; ?>
            </h2>
            <h3>
                <?php echo round($product["price"], 2); ?>€
            </h3>
            <?php if (canAddToCart($product)) : ?>
                <a href="<?php echo getProductUrl($product["id"]); ?>">Add to cart</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>


<style>
    .products {
        display: grid;
        grid-template-columns: 25% 25% 25% 25%;
        margin: 50px auto;
        max-width: 1200px;
        grid-gap: 10px;
        font-family: Arial;
    }

    .product {
        box-shadow: 0px 0px 15px 0px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        padding: 20px;
        background: #fff;
        min-height: 200px;
    }

    .product a {
        background: seagreen;
        color: #ffffff;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
        text-decoration: none;
    }
</style>
