<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\DBHelper;

class City extends AbstractModel implements ModelInterface
{
    private $name;

    protected const TABLE = 'cities';

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function assignData()
    {
        $this->data = [
            'name' => $this->name,
        ];
    }

    public function load($id) {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data['id'];
        $this->name = $data['name'];

        return $this;
    }

    private static function formatList($data){
        $formatted = [];
        foreach ($data as $value) {
            $formatted[$value["id"]] = $value["name"];
        }

        return $formatted;
    }

    /*public static function getList() {
        $db = new DBHelper();
        return self::formatList($db->select()->from("cities")->get());
    }*/

    public static function getCities() {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->get();

        $cities = [];

        foreach($data as $element) {
            $city = new City();
            $city->load($element["id"]);

            $cities[] = $city;
        }

        return $cities;
    }
}