<?php

include 'helper.php';

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$agreeTerms = $_POST["agree_terms"];

$email = clearEmail($email);

if(isPasswordValid($password1, $password2) && isEmailValid($email)) {
    $data = [];
    $password1 = hashPassword($password1);
    $data[] = [$firstName, $lastName, $email, $password1];
    writeToCsv($data, 'users.csv');
}
else{
    echo 'Patikrinkite duomenis ir pabandykite dar karta.';
}
