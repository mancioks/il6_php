<?php

namespace Controller;

use Core\AbstractModel;
use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Url;
use Model\Ad;
use Core\AbstractController;

class Catalog extends AbstractController
{
    public function show($slug)
    {
        $ad = new Ad();
        //$ad->load($id);
        $ad->loadBySlug($slug);
        $ad->setViews($ad->getViews() + 1);
        $ad->save();
        $this->data['ad'] = $ad;
        $this->render("catalog/show");
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

        $ad->setTitle($_POST["title"]);
        $ad->setDescription($_POST["description"]);
        $ad->setManufacturerId(1);
        $ad->setModelId(1);
        $ad->setPrice($_POST["price"]);
        $ad->setYear($_POST["year"]);
        $ad->setTypeId(1);
        $ad->setUserId($_SESSION["user_id"]);
        $ad->setImageUrl($_POST["image_url"]);
        $ad->setVin($_POST["vin"]);
        $ad->setActive(1);
        $ad->setViews(0);
        $ad->setSlug("");

        $ad->save();

        $latestAd = Ad::getLast();

        $slug = Url::generateSlug($latestAd->getTitle());
        while (!Ad::isValueUniq("slug", $slug, 'ads')) {
            $slug = $slug . "-" . $latestAd->getId();
        }

        $latestAd->setSlug($slug);
        $latestAd->save();

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

        $ad->setTitle($_POST["title"]);
        $ad->setDescription($_POST["description"]);
        $ad->setPrice($_POST["price"]);
        $ad->setYear($_POST["year"]);
        $ad->setImageUrl($_POST["image_url"]);
        $ad->setActive($_POST["active"]);
        $ad->setVin($_POST["vin"]);

        $ad->save();

        Url::redirect("catalog/edit/" . $ad->getId());
    }

    public function all()
    {
        $order = [];

        if (isset($_GET["order_by"]) && isset($_GET["clause"])) {
            $order["order_by"] = $_GET["order_by"];
            $order["clause"] = $_GET["clause"];
        }

        $searchForm = new FormHelper("catalog/all", "GET");
        $searchForm->input([
            "type" => "text",
            "name" => "search",
            "placeholder" => "Paieška"
        ]);
        $searchForm->input([
            "type" => "submit",
            "name" => "submit",
            "value" => "search"
        ]);

        $this->data["search_form"] = $searchForm->getForm();

        if (isset($_GET["search"])) {
            $ads = Ad::search($_GET["search"], $order);
        } else {
            $ads = Ad::getAll($order);
        }

        $this->data['ads'] = $ads;

        $this->render("catalog/list");
    }

    public function delete($id)
    {
        $db = new DBHelper();
        $db->delete()->from("ads")->where("id", $id)->exec();

        Url::redirect("catalog/all");
    }
}