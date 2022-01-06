<?php

include 'helper.php';

//$email = $_POST["email"];
//$password = $_POST["password"];
//
//$email = clearEmail($email);

$users = readFromCsv('users.csv');
echo '<pre>';
print_r($users);