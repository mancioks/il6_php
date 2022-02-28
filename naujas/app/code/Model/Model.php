<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Model extends AbstractModel implements ModelInterface
{
    private $name;
    private $manufacturerId;

    protected const TABLE = 'models';

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
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->manufacturerId = $data["manufacturer_id"];

        return $this;
    }

    public static function getModels()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from(self::TABLE)->get();

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
        $data = $db->select("id")->from(self::TABLE)->where("manufacturer_id", $id)->get();

        $models = [];
        foreach ($data as $value) {
            $model = new Model();
            $models[] = $model->load($value["id"]);
        }

        return $models;
    }
}