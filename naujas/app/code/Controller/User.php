<?php

namespace Controller;

use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Model\City;
use Helper\Url;
use Model\User as UserModel;

class User
{
    public function show($id)
    {
        echo 'User controller ID ' . $id;
    }

    public function register()
    {
        $form = new FormHelper('user/create', 'POST');

        $form->input([
            "name" => "name",
            "type" => "text",
            "placeholder" => "Vardas"
        ]);
        $form->input([
            "name" => "last_name",
            "type" => "text",
            "placeholder" => "Last name"
        ]);
        $form->input([
            "name" => "email",
            "type" => "text",
            "placeholder" => "Email"
        ]);
        $form->input([
            "name" => "phone",
            "type" => "text",
            "placeholder" => "Telefonas"
        ]);
        $form->input([
            "name" => "password",
            "type" => "password",
            "placeholder" => "Password"
        ]);
        $form->input([
            "name" => "password2",
            "type" => "password",
            "placeholder" => "Password 2"
        ]);

        $cities = City::getCities();

        $options = [];
        foreach ($cities as $city) {
            $options[$city->getId()] = $city->getName();
        }

        $form->select([
            "name" => "city_id",
            "options" => $options
        ]);

        $form->input([
            "name" => "create",
            "type" => "submit",
            "value" => "Registruotis"
        ]);

        echo $form->getForm();

        //$db = new DBHelper();
        //$db->update("users", ["name"=>"llloooaaa", "lastname"=>"nauja pavarde"])->where('id', 5)->exec();

        echo 'registracija';
    }

    public function login()
    {
        $form = new FormHelper('user/check', 'POST');

        $form->input([
            "name" => "email",
            "type" => "text",
            "placeholder" => "Email"
        ]);
        $form->input([
            "name" => "password",
            "type" => "password",
            "placeholder" => "Password"
        ]);
        $form->input([
            "name" => "login",
            "type" => "submit",
            "value" => "Prisijungti"
        ]);

        echo $form->getForm();

        echo 'prisijungimas';
    }

    public function check()
    {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $userId = UserModel::checkLoginCredentials($email, $password);

        if ($userId) {
            $user = new UserModel();
            $user->load($userId);

            //echo $user->getCity()->getName();

            $_SESSION["logged"] = true;
            $_SESSION["user_id"] = $userId;
            $_SESSION["user"] = $user;

            Url::redirect('');
        } else {
            Url::redirect('user/login');
        }
    }

    public function edit()
    {
        if (isset($_SESSION["user_id"])) {

            $user = new UserModel();
            $user->load($_SESSION["user_id"]);

            $form = new FormHelper('user/editsubmit', 'POST');

            $form->input([
                "name" => "name",
                "type" => "text",
                "placeholder" => "Vardas",
                "value" => $user->getName()
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
                "options" => $options
            ]);

            $form->input([
                "name" => "create",
                "type" => "submit",
                "value" => "Pakeisti"
            ]);

            echo $form->getForm();
        } else {
            Url::redirect('user/login');
        }
    }

    public function logout()
    {
        session_destroy();
        Url::redirect('user/login');
    }

    public function create()
    {
        $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
        $isEmailValid = Validator::checkEmail($_POST['email']);
        $isEmailUniq = UserModel::emailUniq($_POST['email']);

        //echo $isEmailUniq;

        if ($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();

            $user->setName($_POST["name"]);
            $user->setLastName($_POST["last_name"]);
            $user->setEmail($_POST["email"]);
            $user->setPhone($_POST["phone"]);
            $user->setPassword(md5($_POST["password"]));
            $user->setCityId($_POST["city_id"]);

            $user->save();

            Url::redirect('user/login');
        } else {
            echo "Patikrinkite duomenis";
        }

        print_r($_POST);
    }

    public function editsubmit()
    {
        if (isset($_SESSION["user_id"])) {
            $user = new UserModel();
            $user->load($_SESSION["user_id"]);

            $passMatch = true;
            if (!empty($_POST["password"])) {
                $passMatch = Validator::checkPassword($_POST['password'], $_POST['password2']);
            }

            $isEmailUniq = true;
            if ($user->getEmail() != $_POST["email"]) {
                $isEmailUniq = UserModel::emailUniq($_POST['email']);
            }

            $isEmailValid = Validator::checkEmail($_POST['email']);

            if ($passMatch && $isEmailValid && $isEmailUniq) {
                $user->setName($_POST["name"]);
                $user->setLastName($_POST["last_name"]);
                $user->setEmail($_POST["email"]);
                $user->setPhone($_POST["phone"]);

                if (!empty($_POST["password"])) {
                    $user->setPassword(md5($_POST["password"]));
                }

                $user->setCityId($_POST["city_id"]);

                $user->save();

                Url::redirect('user/edit');
            } else {
                echo "Blogi nauji duomenys";
            }

            print_r($_POST);
        } else {
            Url::redirect('user/login');
        }
    }
}