<?php

namespace Controller;

use Helper\FormHelper;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;
use Model\Manufacturer;
use Model\Model;

class Catalog extends AbstractController
{
    public function index()
    {
        $order = [
            "order_by" => "id",
            "clause" => "ASC"
        ];

        if (isset($_GET["order_by"]) && isset($_GET["clause"])) {
            $order["order_by"] = $_GET["order_by"];
            $order["clause"] = $_GET["clause"];
        }

        $ads = Ad::getAll($order);

        $quantity = count($ads);
        $perPage = 6;
        $pages = ceil($quantity / $perPage);

        $page = 1;

        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        }

        if ($page > $pages) {
            $page = $pages;
        }

        if ($page < 1) {
            $page = 1;
        }

        $from = ($page * $perPage) - $perPage;

        $ads = Ad::getAll([
            "order_by" => $order["order_by"],
            "clause" => $order["clause"],
            "limit" => $from . ", " . $perPage
        ]);

        $pagesArray = [];
        for ($x = 1; $x <= $pages; $x++) {
            $pagesArray[] = $x;
        }

        $this->data["pages"] = $pagesArray;
        $this->data["current_page"] = $page;
        $this->data["order"] = $order;
        $this->data['ads'] = $ads;

        $this->render("catalog/list");
    }

    public function show($slug)
    {
        $ad = new Ad();
        //$ad->load($id);
        $ad->loadBySlug($slug);

        if($ad->getId()) {
            $ad->setViews($ad->getViews() + 1);
            $ad->save();
            $this->data['ad'] = $ad;
            $this->data['title'] = $ad->getTitle();
            $this->data['meta_description'] = $ad->getDescription();

            $this->render("catalog/show");
        } else {
            Error::show(404);
        }
    }

    public function create()
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $form = new FormHelper("catalog/insert", "POST");

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title'
        ]);

        $groups = [];
        $manufacturers = Manufacturer::getManufacturers();
        foreach ($manufacturers as $manufacturer) {
            $models = [];
            $modelsObject = Model::getModelsByManufacturerId($manufacturer->getId());

            foreach ($modelsObject as $model) {
                $models[$model->getId()] = $model->getName();
            }

            $groups[$manufacturer->getName()] = $models;
        }

        $form->selectGroup([
            "name"=>"model_id",
            "group" => $groups
        ]);

        $form->textArea("description", "Description");
        $form->input([
            'name' => 'price',
            'type' => 'text',
            'placeholder' => 'Price €'
        ]);

        $years = [];
        for ($x = 1990; $x <= date("Y"); $x++) {
            $years[$x] = $x;
        }

        $form->select([
            'name' => 'year',
            'options' => $years
        ]);
        $form->input([
            'name' => 'image_url',
            'type' => 'text',
            'placeholder' => 'Image url'
        ]);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'placeholder' => 'Vin kodas'
        ]);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Prideti'
        ]);

        $this->data["form"] = $form->getForm();
        $this->render("catalog/create");
    }

    public function edit($adId)
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $ad = new Ad();
        $ad->load($adId);

        if ($_SESSION["user_id"] != $ad->getUserId()) {
            Url::redirect("catalog/all");
        }

        $form = new FormHelper("catalog/update", "POST");

        $form->input([
            'name' => 'title',
            'type' => 'text',
            'placeholder' => 'Title',
            'value' => $ad->getTitle()
        ]);

        $groups = [];
        $manufacturers = Manufacturer::getManufacturers();
        foreach ($manufacturers as $manufacturer) {
            $models = [];
            $modelsObject = Model::getModelsByManufacturerId($manufacturer->getId());

            foreach ($modelsObject as $model) {
                $models[$model->getId()] = $model->getName();
            }

            $groups[$manufacturer->getName()] = $models;
        }

        $form->selectGroup([
            "name"=>"model_id",
            "group" => $groups,
            "selected" => $ad->getModelId()
        ]);

        $form->input([
            'name' => 'ad_id',
            'type' => 'hidden',
            'value' => $ad->getId()
        ]);
        $form->textArea("description", $ad->getDescription());
        $form->input([
            'name' => 'price',
            'type' => 'text',
            'placeholder' => 'Price €',
            'value' => $ad->getPrice()
        ]);
        $form->input([
            'name' => 'image_url',
            'type' => 'text',
            'placeholder' => 'Image url',
            'value' => $ad->getImageUrl()
        ]);
        $form->input([
            'name' => 'vin',
            'type' => 'text',
            'placeholder' => 'Vin kodas',
            'value' => $ad->getVin()
        ]);

        $years = [];
        for ($x = 1990; $x <= date("Y"); $x++) {
            $years[$x] = $x;
        }

        $form->select([
            'name' => 'year',
            'options' => $years,
            'selected' => $ad->getYear()
        ]);
        $form->select([
            'name' => 'active',
            'options' => [1 => "Aktyvus", 0 => "Neaktyvus"],
            'selected' => $ad->getActive()
        ]);
        $form->input([
            'name' => 'submit',
            'type' => 'submit',
            'value' => 'Atnaujinti'
        ]);

        $this->data["form"] = $form->getForm();
        $this->data["ad_title"] = $ad->getTitle();

        $this->render("catalog/edit");
    }

    public function insert()
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $ad = new Ad();

        $latestAd = Ad::getLast();
        $latestId = $latestAd->getId();

        $slug = Url::generateSlug($_POST["title"]);
        while (!Ad::isValueUniq("slug", $slug, 'ads')) {
            $latestId += 1;
            $slug = $slug . "-" . $latestId;
        }

        $model = new Model();
        $model->load($_POST["model_id"]);

        $ad->setTitle($_POST["title"]);
        $ad->setDescription($_POST["description"]);
        $ad->setManufacturerId($model->getManufacturerId());
        $ad->setModelId($_POST["model_id"]);
        $ad->setPrice($_POST["price"]);
        $ad->setYear($_POST["year"]);
        $ad->setTypeId(1);
        $ad->setUserId($_SESSION["user_id"]);
        $ad->setImageUrl($_POST["image_url"]);
        $ad->setVin($_POST["vin"]);
        $ad->setActive(1);
        $ad->setViews(0);
        $ad->setSlug($slug);

        $ad->save();

        Url::redirect("catalog/create");
    }

    public function update()
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect("user/login");
        }

        $adId = $_POST["ad_id"];
        $ad = new Ad();
        $ad->load($adId);

        $model = new Model();
        $model->load($_POST["model_id"]);

        $ad->setTitle($_POST["title"]);
        $ad->setModelId($_POST["model_id"]);
        $ad->setManufacturerId($model->getManufacturerId());
        $ad->setDescription($_POST["description"]);
        $ad->setPrice($_POST["price"]);
        $ad->setYear($_POST["year"]);
        $ad->setImageUrl($_POST["image_url"]);
        $ad->setActive($_POST["active"]);
        $ad->setVin($_POST["vin"]);

        $ad->save();

        Url::redirect("catalog/edit/" . $ad->getId());
    }


    public function results()
    {
        if (isset($_GET["search"]) && !empty($_GET["search"])) {
            $ads = Ad::search($_GET["search"]);

            $this->data['search_query'] = $_GET["search"];
            $this->data['ads'] = $ads;
            $this->data['quantity'] = count($ads);
        } else {
            $this->data['search_query'] = "";
            $this->data['ads'] = [];
            $this->data['quantity'] = 0;
        }

        $this->render("catalog/results");
    }

    public function delete($id)
    {
        $ad = new Ad();
        $ad->load($id);

        if ($ad->getUserId() == $_SESSION["user_id"]) {
            $ad->setActive(0);
        }

        Url::redirect("catalog/all");
    }
}