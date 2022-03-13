<?php

function getNickName($name, $surName) {
    return strtolower(substr($name, 0, 3).substr($surName, 0, 3)).mt_rand(1, 100);
}
function clearEmail($email){
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}
function isEmailValid($email){
    if (str_contains($email, '@') && str_contains($email, '.')) {
        return true;
    }
    return false;
}


if(isset($_POST["submit"])) {
    $name = $_POST["vardas"];
    $pavarde = $_POST["pavarde"];
    $email = clearEmail($_POST["email"]);
    $password = $_POST["password"];
    $passwordVerify = $_POST["passwordVerify"];

    $canRegister = true;

    if(!isEmailValid($email)) {
        $canRegister = false;
    }
    if($password != $passwordVerify) {
        $canRegister = false;
    }
    if(strlen($password) < 6) {
        $canRegister = false;
    }

    if($canRegister) {
        echo "Registracija sėkminga!";
    }
}

