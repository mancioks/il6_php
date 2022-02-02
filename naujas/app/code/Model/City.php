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

    public function save()
    {
        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
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
        $db = new DBHelper();
        $db->update('cities', ["name" => $this->name])->where('id', $this->id)->exec();
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

    private static function formatList($data){
        $formatted = [];
        foreach ($data as $value) {
            $formatted[$value["id"]] = $value["name"];
        }

        return $formatted;
    }

    public static function getList() {
        $db = new DBHelper();
        return self::formatList($db->select()->from("cities")->get());
    }
}