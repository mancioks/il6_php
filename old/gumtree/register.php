<?php

include 'parts/header.php';

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


if(isset($_POST["register"])) {
    $name = $_POST["name"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $phone = $_POST["phone"];

    if($password === $password2) {
        $sql = "INSERT INTO users (name, lastname, email, password, phone, city_id) 
            VALUES ('" . $name . "', '" . $lastname . "', '" . $email . "', '" . md5($password) . "', '" . $phone . "', 1)";
        $conn->query($sql);
        echo "good!";
    }
    else {
        echo "password do not match";
    }

}

include 'parts/footer.php';