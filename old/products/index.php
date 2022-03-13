<?php
include_once "helper.php";
?>

<form action="add.php" method="post">
    <input type="text" name="productName" placeholder="Product name"><br>
    <input type="text" name="productSku" placeholder="Product SKU"><br>
    <input type="number" name="productQty" placeholder="Product QTY"><br>
    <input type="text" name="productPrice" placeholder="Product Price"><br>
    <input type="submit" value="Add product">
</form>

<a href="<?php echo URL; ?>/products.php">PRODUCT LIST</a>