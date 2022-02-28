<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class Manufacturer extends AbstractModel implements ModelInterface
{
    private $name;

    protected const TABLE = 'manufacturers';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
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
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->name = $data["name"];

        return $this;
    }

    public static function getManufacturers()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from(self::TABLE)->get();

        $manufacturers = [];
        foreach ($data as $value) {
            $manufacturer = new Manufacturer();
            $manufacturers[] = $manufacturer->load($value["id"]);
        }

        return $manufacturers;
    }
}