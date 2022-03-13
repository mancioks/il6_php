<?php

include 'helper.php';

$email = $_POST["email"];
$password = $_POST["password"];

$email = clearEmail($email);
$password = hashPassword($password);

$users = readFromCsv('users.csv');
//debug($users);
$login = false;

//debug($users);

foreach ($users as $user) {
    if($password === $user[PASSWORD_FIELD_KEY] && $email === $user[EMAIL_FIELD_KEY]) {
        $login = true;
        break;
    }
}

if($login) {
    echo "Prisijungete";
}
else {
    echo "wrong email";
}