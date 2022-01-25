<?php

include 'FormHelper.php';

$data = [
    'type'=>'text',
    'name'=>'name',
    'placeholder'=>'vardas'
];
$dataSelect = [
    "name"=>"select",
    "options" => [
        "a"=>"a",
        "b"=>"b"
    ]
];

$form = new FormHelper('register.php', 'post');
$form->input($data);
$form->input($data);

$form->textArea("vardas", "holderis");
$form->select($dataSelect);


echo $form->getForm();