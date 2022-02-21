<?php

namespace Controller;

use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Model\City;
use Helper\Url;
use Model\User as UserModel;
use Core\AbstractController;

class User extends AbstractController
{
    public function index()
    {
        $this->data['users'] = UserModel::getAll();
        $this->render("user/list");
    }

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

        $this->data['form'] = $form->getForm();

        $this->render("user/register");
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

        $this->data['form'] = $form->getForm();

        $this->render("user/login");
    }

    public function check()
    {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $userId = UserModel::checkLoginCredentials($email, $password);

        if (!UserModel::canLogin($email)) {
            Url::redirect('user/login');
        }

        if ($userId) {
            $user = new UserModel();
            $user->load($userId);
            $user->setIncorrectTries(0);

            //echo $user->getCity()->getName();

            $_SESSION["logged"] = true;
            $_SESSION["user_id"] = $userId;
            $_SESSION["user"] = $user;

            Url::redirect('');
        } else {
            if (UserModel::isUserExists($email)) {
                $user = new UserModel();
                $user->loadUserByEmail($email);

                $user->setIncorrectTries($user->getIncorrectTries() + 1);

                if ($user->getIncorrectTries() >= 5) {
                    $user->setIncorrectTries(0);
                    $user->setActive(0);
                }

                $user->save();
            }
            Url::redirect('user/login');
        }
    }

    public function edit()
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect('user/login');
        }

        $userId = $_SESSION["user_id"];
        $user = new UserModel();
        $user->load($userId);

        $form = new FormHelper('user/update', 'POST');

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
            "options" => $options,
            "selected" => $user->getCityId()
        ]);

        $form->input([
            "name" => "create",
            "type" => "submit",
            "value" => "Pakeisti"
        ]);

        $this->data['form'] = $form->getForm();

        $this->render("user/edit");
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
        $isEmailUniq = UserModel::isValueUniq("email", $_POST['email'], "users");

        //echo $isEmailUniq;

        if ($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();

            $user->setName($_POST["name"]);
            $user->setLastName($_POST["last_name"]);
            $user->setEmail($_POST["email"]);
            $user->setPhone($_POST["phone"]);
            $user->setPassword(md5($_POST["password"]));
            $user->setCityId($_POST["city_id"]);
            $user->setActive(1);
            $user->setIncorrectTries(0);
            $user->setActive(1);
            $user->setRoleId(0);

            $user->save();

            Url::redirect('user/login');
        } else {
            echo "Patikrinkite duomenis";
        }
    }

    public function update()
    {
        if (!isset($_SESSION["user_id"])) {
            Url::redirect('user/login');
        }

        $userId = $_SESSION["user_id"];
        $user = new UserModel();
        $user->load($userId);

        $user->setName($_POST["name"]);
        $user->setLastName($_POST["last_name"]);
        $user->setPhone($_POST["phone"]);
        $user->setCityId($_POST["city_id"]);

        if (!empty($_POST["password"]) && Validator::checkPassword($_POST["password"], $_POST["password2"])) {
            $user->setPassword(md5($_POST["password"]));
        }

        if ($user->getEmail() != $_POST["email"]) {
            if (Validator::checkEmail($_POST["email"]) && UserModel::isValueUniq("email", $_POST["email"], "users")) {
                $user->setEmail($_POST["email"]);
            }
        }

        $user->save();

        Url::redirect('user/edit');
    }
}