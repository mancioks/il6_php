<?php

const EMAIL_FIELD_KEY = 2;
const NICKNAME_FIELD_KEY = 3;
const PASSWORD_FIELD_KEY = 4;

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
        if(!empty($line)) {
            $data[] = $line;
        }
    }

    fclose($fh);
    return $data;
}

function debug($data) {
    echo "<pre>";
    var_dump($data);
    die();
}

function isValueUniq($users, $value, $key) {
    foreach ($users as $user) {
        if($user[$key] === $value) {
            return false;
        }
    }
    return true;
}

function generateNickName($firstName, $lastName) {
    return strtolower(substr($firstName, 0, 3).substr($lastName, 0, 3));
}