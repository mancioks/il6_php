<?php

function clearEmail($email) {
    return trim(strtolower($email));
}

function isEmailValid($email) {
    return str_contains($email, "@");
}

function isPasswordValid($pass1, $pass2) {
    return $pass1 === $pass2 && strlen($pass1) > 8;
}

function writeToCsv($data, $fileName) {
    $file = fopen($fileName, 'a');
    foreach ($data as $element) {
        fputcsv($file, $element);
    }
    fclose($file);
}