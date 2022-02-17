<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Model extends AbstractModel
{
    private $name;
    private $manufacturerId;

    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;
    }
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    public function __construct()
    {
        $this->table = "models";
    }

    public function assignData()
    {
        $this->data = [
            "name" => $this->name,
            "manufacturer_id" => $this->manufacturerId
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from($this->table)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->manufacturerId = $data["manufacturer_id"];

        return $this;
    }

    public static function getModels()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("models")->get();

        $models = [];
        foreach ($data as $value) {
            $model = new Model();
            $models[] = $model->load($value["id"]);
        }

        return $models;
    }

    public static function getModelsByManufacturerId($id)
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("models")->where("manufacturer_id", $id)->get();

        $models = [];
        foreach ($data as $value) {
            $model = new Model();
            $models[] = $model->load($value["id"]);
        }

        return $models;
    }
}