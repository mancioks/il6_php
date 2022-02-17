<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Manufacturer extends AbstractModel
{
    private $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->table = "manufacturers";
    }

    public function assignData()
    {
        $this->data = [
            "name" => $this->name
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from($this->table)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->name = $data["name"];

        return $this;
    }

    public static function getManufacturers()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("manufacturers")->get();

        $manufacturers = [];
        foreach ($data as $value) {
            $manufacturer = new Manufacturer();
            $manufacturers[] = $manufacturer->load($value["id"]);
        }

        return $manufacturers;
    }
}