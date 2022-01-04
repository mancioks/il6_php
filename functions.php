<?php

$userEmail = "belekas@beleka.lt";

if(isEmailValid($userEmail)){
    echo clearEmail($userEmail);
}else{
    echo 'Emailas nevalidus';
}

function isEmailValid($email){
    if (str_contains($email, '@') && str_contains($email, '.')) {
        return true;
    }
    return false;
}


function clearEmail($email){
    $emailLowercases = strtolower($email);
    return trim($emailLowercases);
}

$name = "Mantas";
$surname = "Kryževičius";

function getNickName($name, $surName) {
    return strtolower(substr($name, 0, 3).substr($surName, 0, 3));
}

echo getNickName($name, $surname);