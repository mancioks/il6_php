<?php

namespace Controller;

use Core\AbstractController;
use Helper\FormHelper;
use Helper\Url;
use Helper\Validator;
use Model\Ad;
use Model\City;
use Model\Manufacturer;
use Model\Model;
use Model\User;

class Admin extends AbstractController
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->isUserAdmin()) {
            Url::redirect('');
        }
    }

    public function index()
    {
        $this->renderAdmin('index');
    }

    public function users()
    {
        $users = User::getAll();
        $this->data['users'] = $users;
        $this->renderAdmin('users/list');

    }

    public function ads()
    {
        $ads = Ad::getAll(["order_by" => "id", "clause" => "DESC"], true);

        $this->data['ads'] = $ads;
        $this->renderAdmin('ads/list');
    }

    public function adedit($adId)
    {
        if(Ad::exists($adId)) {
            $ad = new Ad();
            $ad->load($adId);

            $form = new FormHelper("admin/adupdate", "POST");

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

            $this->renderAdmin("ads/edit");
        } else {
            Url::redirect("admin/ads");
        }
    }

    public function adupdate()
    {
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

        Url::redirect("admin/adedit/" . $ad->getId());
    }

    public function useredit($userId)
    {
        if(User::exists($userId)) {
            $user = new User();
            $user->load($userId);

            $form = new FormHelper('admin/userupdate', 'POST');

            $form->input([
                "name" => "name",
                "type" => "text",
                "placeholder" => "Vardas",
                "value" => $user->getName()
            ]);
            $form->input([
                "name" => "user_id",
                "type" => "hidden",
                "value" => $userId
            ]);
            $form->input([
                "name" => "last_name",
                "type" => "text",
                "placeholder" => "Last name",
                "value" => $user->getLastName()
            ]);
            $form->input([
                "name" => "email",
                "type" => "text",
                "placeholder" => "Email",
                "value" => $user->getEmail()
            ]);
            $form->input([
                "name" => "phone",
                "type" => "text",
                "placeholder" => "Telefonas",
                "value" => $user->getPhone()
            ]);
            $form->input([
                "name" => "password",
                "type" => "password",
                "placeholder" => "New password"
            ]);
            $form->input([
                "name" => "password2",
                "type" => "password",
                "placeholder" => "New password"
            ]);

            $cities = City::getCities();

            $options = [];
            foreach ($cities as $city) {
                $options[$city->getId()] = $city->getName();
            }

            $form->select([
                "name" => "city_id",
                "options" => $options,
                "selected" => $user->getCityId()
            ]);

            $form->select([
                "name" => "active",
                "options" => ["0" => "Neaktyvus", "1" => "Aktyvus"],
                "selected" => $user->getActive()
            ]);

            $form->input([
                "name" => "create",
                "type" => "submit",
                "value" => "Pakeisti"
            ]);

            $this->data['form'] = $form->getForm();

            $this->renderAdmin("users/edit");
        } else {
            Url::redirect("admin/users");
        }
    }

    public function userupdate()
    {
        $userId = $_POST["user_id"];
        $user = new User();
        $user->load($userId);

        $user->setName($_POST["name"]);
        $user->setLastName($_POST["last_name"]);
        $user->setPhone($_POST["phone"]);
        $user->setCityId($_POST["city_id"]);
        $user->setActive($_POST["active"]);

        if (!empty($_POST["password"]) && Validator::checkPassword($_POST["password"], $_POST["password2"])) {
            $user->setPassword(md5($_POST["password"]));
        }

        if ($user->getEmail() != $_POST["email"]) {
            if (Validator::checkEmail($_POST["email"]) && User::isValueUniq("email", $_POST["email"])) {
                $user->setEmail($_POST["email"]);
            }
        }

        $user->save();

        Url::redirect('admin/useredit/' . $userId);
    }

    public function editselectedads()
    {
        $checkedAds = [];
        if(isset($_POST["checked_ads"])) {
            $checkedAds = $_POST["checked_ads"];
        }

        $withSelected = $_POST["with_selected"];

        $selectedAds = Ad::getCollection($checkedAds);

        /**
         * @var \Model\Ad $selectedAd
         */
        foreach ($selectedAds as $selectedAd) {
            switch ($withSelected) {
                case "activate":
                    $selectedAd->setActive(1);
                    break;

                case "deactivate":
                    $selectedAd->setActive(0);
                    break;
            }

            $selectedAd->save();
        }

        Url::redirect("admin/ads");
    }

    public function editselectedusers()
    {
        $checkedUsers = [];
        if(isset($_POST["checked_users"])) {
            $checkedUsers = $_POST["checked_users"];
        }

        $withSelected = $_POST["with_selected"];

        $selectedUsers = User::getCollection($checkedUsers);

        /**
         * @var \Model\User $selectedUser
         */
        foreach ($selectedUsers as $selectedUser) {
            switch ($withSelected) {
                case "activate":
                    $selectedUser->setActive(1);
                    break;

                case "deactivate":
                    $selectedUser->setActive(0);
                    break;
            }

            $selectedUser->save();
        }

        Url::redirect("admin/users");
    }
}