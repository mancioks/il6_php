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

function hashPassword($password) {
    return md5(md5($password).'druska');
}

function writeToCsv($data, $fileName) {
    $file = fopen($fileName, 'a');

    foreach ($data as $element) {
        fputcsv($file, $element);
    }

    fclose($file);
}

function readFromCsv($fileName) {
    $data = [];
    $fh = fopen($fileName, 'r');

    while (!feof($fh)) {
        $line = fgetcsv($fh);
        $data[] = $line;
    }

    fclose($fh);
    return $data;
}

