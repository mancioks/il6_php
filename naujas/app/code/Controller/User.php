<?php

namespace Controller;
use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Model\City;
use Model\User as UserModel;

class User
{
    public function show($id) {
        echo 'User controller ID '.$id;
    }
    public function register() {
        $form = new FormHelper('user/create', 'POST');

        $cities = City::getList();
        $dataToSelect["name"] = "city_id";
        $dataToSelect["options"] = [];

        foreach ($cities as $value) {
            $dataToSelect["options"][$value["id"]] = $value["name"];
        }

        $form->input([
            "name"=>"name",
            "type"=>"text",
            "placeholder"=>"Vardas"
        ]);
        $form->input([
            "name"=>"last_name",
            "type"=>"text",
            "placeholder"=>"Last name"
        ]);
        $form->input([
            "name"=>"email",
            "type"=>"text",
            "placeholder"=>"Email"
        ]);
        $form->input([
            "name"=>"phone",
            "type"=>"text",
            "placeholder"=>"Telefonas"
        ]);
        $form->input([
            "name"=>"password",
            "type"=>"password",
            "placeholder"=>"Password"
        ]);
        $form->input([
            "name"=>"password2",
            "type"=>"password",
            "placeholder"=>"Password 2"
        ]);
        $form->select($dataToSelect);

        $form->input([
            "name"=>"create",
            "type"=>"submit",
            "value"=>"Registruotis"
        ]);

        echo $form->getForm();

        //$db = new DBHelper();
        //$db->update("users", ["name"=>"llloooaaa", "lastname"=>"nauja pavarde"])->where('id', 5)->exec();

        echo 'registracija';
    }

    public function login() {
        $form = new FormHelper('user/check', 'POST');

        $form->input([
            "name"=>"email",
            "type"=>"text",
            "placeholder"=>"Email"
        ]);
        $form->input([
            "name"=>"password",
            "type"=>"password",
            "placeholder"=>"Password"
        ]);
        $form->input([
            "name"=>"login",
            "type"=>"submit",
            "value"=>"Prisijungti"
        ]);

        echo $form->getForm();

        echo 'prisijungimas';
    }

    public function check() {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $userId = UserModel::checkLoginCredentials($email, $password);

        if($userId) {
            $user = new UserModel();
            $user->load($userId);

            echo "<pre>";
            print_r($user);
        } else {
            echo "blogai";
        }
    }

    public function create()
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);

        //echo $isEmailUniq;

        if($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();

            $user->setName($_POST["name"]);
            $user->setLastName($_POST["name"]);
            $user->setEmail($_POST["email"]);
            $user->setPhone($_POST["phone"]);
            $user->setPassword(md5($_POST["password"]));
            $user->setCityId($_POST["city_id"]);

            $user->save();
        }

        print_r($_POST);
    }
}