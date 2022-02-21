<?php

namespace Core;

use Helper\DBHelper;
use Model\Ad;

class AbstractModel
{
    protected $table;
    protected $data;
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    private function getTable()
    {
        return $this->table;
    }

    protected function assignData(){
        $this->data = [];
    }

    public function save()
    {
        $this->assignData();

        if (!isset($this->id)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    private function create()
    {
        $db = new DBHelper();
        $db->insert($this->table, $this->data)->exec();
    }

    private function update() {
        $db = new DBHelper();
        $db->update($this->table, $this->data)->where('id', $this->id)->exec();
    }

    public function delete() {
        $db = new DBHelper();
        $db->delete()->from($this->table)->where("id", $this->id)->exec();
    }

    public static function isValueUniq($column, $value, $table)
    {
        $db = new DBHelper();

        $rez = $db->select()->from($table)->where($column, $value)->get();

        return empty($rez);
        //return $rez;
    }

    public static function count()
    {
        $db = new DBHelper();
        $currentModel = new static();
        $count = $db->select("count(*)")->from($currentModel->table)->getOne();

        return $count[0];
    }

    public static function getCollection($ids)
    {
        $objects = [];
        foreach ($ids as $id) {
            $object = new static();
            $object->load($id);
            $objects[] = $object;
        }

        return $objects;
    }
}