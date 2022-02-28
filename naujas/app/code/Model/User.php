<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\ArrayHelper;
use Helper\DBHelper;
use Helper\Validator;
use Model\City;

class User extends AbstractModel implements ModelInterface
{
    private $name;
    private $lastName;
    private $email;
    private $password;
    private $phone;
    private $cityId;
    private $city;
    private $active;
    private $incorrectTries;
    private $roleId;

    protected const TABLE = 'users';

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCityId()
    {
        return $this->cityId;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCityId($cityId)
    {
        $this->cityId = $cityId;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
    public function setIncorrectTries($incorrectTries)
    {
        $this->incorrectTries = $incorrectTries;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getIncorrectTries()
    {
        return $this->incorrectTries;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function assignData()
    {
        $this->data = [
            'name' => $this->name,
            'lastname' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
            'phone' => $this->phone,
            'city_id' => $this->cityId,
            'active' => $this->active,
            'incorrect_tries' => $this->incorrectTries,
            'role_id' => $this->roleId
        ];
    }

    public function load($id) {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->lastName = $data['lastname'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->phone = $data['phone'];
        $this->cityId = $data['city_id'];
        $this->active = $data['active'];
        $this->incorrectTries = $data['incorrect_tries'];
        $this->roleId = $data['role_id'];

        $city = new City();
        $this->city = $city->load($this->cityId);

        return $this;
    }

    public static function checkLoginCredentials($email, $password) {
        $db = new DBHelper();
        $rez = $db->select("id")->from(self::TABLE)->where("email", $email)->andWhere("password", $password)->getOne();

        return isset($rez["id"]) ? $rez["id"] : false;
    }

    public static function getAll()
    {
        $db = new DBHelper();

        $data = $db->select('id')->from(self::TABLE)->get();

        $users = [];

        foreach ($data as $element) {
            $user = new User();
            $user->load($element["id"]);
            $users[] = $user;
        }

        return $users;
    }

    public static function canLogin($userEmail)
    {
        $db = new DBHelper();
        $data = $db->select("active")->from(self::TABLE)->where("email", $userEmail)->getOne();

        return isset($data["active"]) && $data["active"] == 1;
    }

    public static function isUserExists($userEmail)
    {
        return !(User::isValueUniq("email", $userEmail, "users"));
    }

    public function loadUserByEmail($email)
    {
        $db = new DBHelper();
        $user = $db->select("id")->from(self::TABLE)->where("email", $email)->getOne();

        if(isset($user["id"])) {
            $this->load($user["id"]);
        }

        return $this;
    }

    public function getAds()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("ads")->where("user_id", $this->id)->get();
        $data = ArrayHelper::rowsToIds($data);

        return Ad::getCollection($data);
    }
}