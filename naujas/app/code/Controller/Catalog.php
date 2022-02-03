<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Url;
use Model\Ad;

class Catalog
{
    public function show($id) {
        echo 'Catalog controller ID '.$id;
    }

    public function create()
    {
        if(!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $form = new FormHelper("catalog/insert", "POST");

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title'
        ]);
        $form->textArea("description", "Description");
        $form->input([
            'name' => 'price',
            'type' => 'text',
            'placeholder' => 'Price €'
        ]);

        $years = [];
        for($x = 1990; $x <= date("Y"); $x++) {
            $years[$x] = $x;
        }

        $form->select([
            'name' => 'year',
            'options' => $years
        ]);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Prideti'
        ]);
        echo $form->getForm();
    }

    public function insert() {
        if(!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $ad = new Ad();

        $ad->setTitle($_POST["title"]);
        $ad->setDescription($_POST["description"]);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST["price"]);
        $ad->setYear($_POST["year"]);
        $ad->setTypeId(1);
        $ad->setUserId($_SESSION["user_id"]);

        $ad->save();

        Url::redirect("catalog/create");
    }
}