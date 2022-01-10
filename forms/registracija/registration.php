<?php

include 'helper.php';

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];

$email = clearEmail($email);

$users = readFromCsv('users.csv');

if (
    isPasswordValid($password1, $password2) &&
    isEmailValid($email) &&
    isValueUniq($users, $email, EMAIL_FIELD_KEY) &&
    isset($_POST["agree_terms"])
) {

    $nickName = generateNickName($firstName, $lastName);

    while (!isValueUniq($users, $nickName, NICKNAME_FIELD_KEY)) {
        $nickName = $nickName . rand(0, 100);
    }

    $data = [];
    $password1 = hashPassword($password1);
    $data[] = [$firstName, $lastName, $email, $nickName, $password1];
    writeToCsv($data, 'users.csv');
} else {
    echo 'Patikrinkite duomenis ir pabandykite dar karta.';
}
