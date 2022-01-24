<?php include 'parts/header.php'; ?>

<?php

$servername = "localhost";
$username = "root";
$password = "root";
$database = "autoplius";

try {
    $conn = new PDO("mysql:host=$servername;dbname=".$database, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql = "SELECT * FROM ads";
$rez = $conn->query($sql);
$ads = $rez->fetchAll();

echo '<div class="wrapper">';

foreach ($ads as $ad) {
    echo '<div class="ad-box">';
    echo '<div class="title">'.$ad["title"].'</div>';
    echo '<div class="price">'.$ad["price"].'</div>';
    echo '<div class="year">'.$ad["year"].'</div>';
    echo '<a href="ad.php?id='.$ad["id"].'">More</a>';
    echo '</div>';
}

echo '</div>';

?>

<?php include 'parts/footer.php'; ?>