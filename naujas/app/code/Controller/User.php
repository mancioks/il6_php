<?php

namespace Controller;

use Core\Interfaces\ControllerInterface;
use Helper\DBHelper;
use Helper\FormHelper;
use Helper\Validator;
use Model\City;
use Helper\Url;
use Model\User as UserModel;
use Core\AbstractController;

class User extends AbstractController implements ControllerInterface
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
        $email = $this->request->post("email");
        $password = md5($this->request->post("password"));

        $userId = UserModel::checkLoginCredentials($email, $password);

        if (!UserModel::canLogin($email)) {
            Url::redirect('user/login');
        }

        if ($userId) {
            $user = new UserModel();
            $user->load($userId);
            $user->setIncorrectTries(0);

            //echo $user->getCity()->getName();

            $this->session->set("logged")->value(true);
            $this->session->set("user_id")->value($userId);
            $this->session->set("user")->value($user);

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
        if (!$this->session->get("user_id")) {
            Url::redirect('user/login');
        }

        $userId = $this->session->get("user_id");
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
        $passMatch = Validator::checkPassword($this->request->post("password"), $this->request->post("password2"));
        $isEmailValid = Validator::checkEmail($this->request->post("email"));
        $isEmailUniq = UserModel::isValueUniq("email", $this->request->post("email"));

        //echo $isEmailUniq;

        if ($passMatch && $isEmailValid && $isEmailUniq) {
            $user = new UserModel();

            $user->setName($this->request->post("name"));
            $user->setLastName($this->request->post("last_name"));
            $user->setEmail($this->request->post("email"));
            $user->setPhone($this->request->post("phone"));
            $user->setPassword(md5($this->request->post("password")));
            $user->setCityId($this->request->post("city_id"));
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
        if (!$this->session->get("user_id")) {
            Url::redirect('user/login');
        }

        $userId = $this->session->get("user_id");
        $user = new UserModel();
        $user->load($userId);

        $user->setName($this->request->post("name"));
        $user->setLastName($this->request->post("last_name"));
        $user->setPhone($this->request->post("phone"));
        $user->setCityId($this->request->post("city_id"));

        if (!empty($this->request->post("password")) && Validator::checkPassword($this->request->post("password"), $this->request->post("password2"))) {
            $user->setPassword(md5($this->request->post("password")));
        }

        if ($user->getEmail() != $this->request->post("email")) {
            if (Validator::checkEmail($this->request->post("email")) && UserModel::isValueUniq("email", $this->request->post("email"))) {
                $user->setEmail($this->request->post("email"));
            }
        }

        $user->save();

        Url::redirect('user/edit');
    }
}