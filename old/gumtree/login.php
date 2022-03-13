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


if(isset($_POST["login"])) {
    $userEmail = $_POST["email"];
    $userPassword = md5($_POST["password"]);

    $sql = 'SELECT * FROM users WHERE email = "'.$userEmail.'" AND password = "'.$userPassword.'"';
    $user = $conn->query($sql)->fetchAll();

    if(!empty($user)) {
        echo "prisijungei";
    }
    else {
        echo "wrong credentials";
    }

}

include 'parts/footer.php';