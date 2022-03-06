<?php

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Logger;
use Helper\Messages;
use Helper\Url;
use Helper\Validator;
use Model\Ad;
use Core\AbstractController;
use Model\Comment;
use Model\Manufacturer;
use Model\Model;
use Model\User as UserModel;

class Catalog extends AbstractController implements ControllerInterface
{
    public function index()
    {
        $order = [
            "order_by" => "id",
            "clause" => "ASC"
        ];

        if ($this->request->get("order_by") && $this->request->get("clause")) {
            $order["order_by"] = $this->request->get("order_by");
            $order["clause"] = $this->request->get("clause");
        }

        $quantity = Ad::count();

        $perPage = 6;
        $pages = ceil($quantity / $perPage);

        $page = 1;

        if ($this->request->get("page")) {
            $page = $this->request->get("page");
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

        if ($ad->getId()) {
            $ad->setViews($ad->getViews() + 1);
            $ad->save();

            Validator::generateSecurityQuestion();

            $relatedAds = Ad::getRelatedAds($ad, ["limit" => 5]);

            $commentForm = new FormHelper("catalog/comment", "post");
            $commentForm->textArea("comment", "Komentaras");
            $commentForm->input(["type"=>"hidden", "name"=>"ad_id", "value"=>$ad->getId()]);
            $commentForm->label(Validator::getSecurityQuestion(), "security_answer");
            $commentForm->input(["type"=>"text", "name"=>"security_answer", "placeholder"=>"Answer", "id" => "security_answer"]);
            $commentForm->input(["type"=>"submit", "name"=>"submit", "value"=>"Rašyti"]);

            $this->data['comment_form'] = $commentForm->getForm();

            $this->data['ad'] = $ad;

            $this->data['has_related_ads'] = count($relatedAds) > 0;
            $this->data['related_ads'] = $relatedAds;

            $this->data['title'] = $ad->getTitle();
            $this->data['meta_description'] = $ad->getDescription();

            $this->data['messages'] = Messages::getMessages();

            $this->render("catalog/show");
        } else {
            Error::show(404);
        }
    }

    public function myads()
    {
        if(!$this->isUserLogged()) {
            Url::redirect("user/login");
        }

        $currentUser = new UserModel();
        $currentUser->load($this->session->get("user_id"));

        $ads = $currentUser->getAds();
        if(count($ads) == 0)
            $ads = false;

        $this->data["ads"] = $currentUser->getAds();

        $this->render("catalog/myads");
    }

    public function comment()
    {
        if(!$this->isUserLogged()) {
            Url::redirect("user/login");
        }

        $ad = new Ad();
        $ad->load($this->request->post("ad_id"));

        if(!$this->request->post("comment") || strlen($this->request->post("comment")) <= 5) {
            Messages::store("Per trumpas komentaras", 0);
        }
        if(!$this->request->post("security_answer") || $this->request->post("security_answer") != Validator::getSecurityAnswer()) {
            Messages::store("Blogas atsakymas i saugos klausima", 0);
        }

        if(Messages::hasErrors()) {
            Url::redirect("catalog/show/" . $ad->getSlug());
        }

        $comment = new Comment();
        $comment->setUserId($this->session->get("user_id"));
        $comment->setAdId($this->request->post("ad_id"));
        $comment->setComment($this->request->post("comment"));

        $comment->save();

        Messages::store("Komentaras parašytas", 2);

        Url::redirect("catalog/show/" . $ad->getSlug());
    }

    public function create()
    {
        if (!$this->session->get("user_id")) {
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
            "name" => "model_id",
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
        if (!$this->session->get("user_id")) {
            Url::redirect("user/login");
        }

        $ad = new Ad();
        $ad->load($adId);

        if ($this->session->get("user_id") != $ad->getUserId()) {
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
            "name" => "model_id",
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
        if (!$this->session->get("user_id")) {
            Url::redirect("user/login");
        }

        $ad = new Ad();

        $latestAd = Ad::getLast();
        $latestId = $latestAd->getId();

        $slug = Url::generateSlug($this->request->post("title"));
        while (!Ad::isValueUniq("slug", $slug)) {
            $latestId += 1;
            $slug = $slug . "-" . $latestId;
        }

        $model = new Model();
        $model->load($this->request->post("model_id"));

        $ad->setTitle($this->request->post("title"));
        $ad->setDescription($this->request->post("description"));
        $ad->setManufacturerId($model->getManufacturerId());
        $ad->setModelId($this->request->post("model_id"));
        $ad->setPrice($this->request->post("price"));
        $ad->setYear($this->request->post("year"));
        $ad->setTypeId(1);
        $ad->setUserId($this->session->get("user_id"));
        $ad->setImageUrl($this->request->post("image_url"));
        $ad->setVin($this->request->post("vin"));
        $ad->setActive(1);
        $ad->setViews(0);
        $ad->setSlug($slug);

        $ad->save();

        Url::redirect("catalog/create");
    }

    public function update()
    {
        if (!$this->session->get("user_id")) {
            Url::redirect("user/login");
        }

        $adId = $this->request->post("ad_id");
        $ad = new Ad();
        $ad->load($adId);

        $model = new Model();
        $model->load($this->request->post("model_id"));

        $ad->setTitle($this->request->post("title"));
        $ad->setModelId($this->request->post("model_id"));
        $ad->setManufacturerId($model->getManufacturerId());
        $ad->setDescription($this->request->post("description"));
        $ad->setPrice($this->request->post("price"));
        $ad->setYear($this->request->post("year"));
        $ad->setImageUrl($this->request->post("image_url"));
        $ad->setActive($this->request->post("active"));
        $ad->setVin($this->request->post("vin"));

        $ad->save();

        Url::redirect("catalog/edit/" . $ad->getId());
    }


    public function results()
    {
        if (!empty($this->request->get("search"))) {
            $ads = Ad::search($this->request->get("search"));

            $this->data['search_query'] = $this->request->get("search");
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

        if ($ad->getUserId() == $this->session->get("user_id")) {
            $ad->setActive(0);
        }

        Url::redirect("catalog/all");
    }
}