<?php

namespace Model;

use Helper\DBHelper;

class City
{
    private $id;
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    private function create()
    {
        $data = [
            'name' => $this->name,
        ];

        $db = new DBHelper();
        $db->insert('cities', $data)->exec();
    }

    private function update() {

    }

    public function delete() {
        $db = new DBHelper();
        $db->delete()->from("cities")->where("id", $this->id)->exec();
    }

    public function load($id) {
        $db = new DBHelper();
        $data = $db->select()->from("cities")->where("id", $id)->getOne();

        $this->id = $data['id'];
        $this->name = $data['name'];
    }

    public static function getList() {
        $db = new DBHelper();
        $rez = $db->select()->from("cities")->get();

        return $rez;
    }
}