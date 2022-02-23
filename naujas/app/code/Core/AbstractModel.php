<?php

namespace Core;

use Helper\DBHelper;
use Model\Ad;

class AbstractModel
{
    protected const TABLE = '';

    protected $data;
    protected $id;

    public function getId()
    {
        return $this->id;
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
        $db->insert(static::TABLE, $this->data)->exec();
    }

    private function update() {
        $db = new DBHelper();
        $db->update(static::TABLE, $this->data)->where('id', $this->id)->exec();
    }

    public function delete() {
        $db = new DBHelper();
        $db->delete()->from(static::TABLE)->where("id", $this->id)->exec();
    }

    public static function isValueUniq($column, $value)
    {
        $db = new DBHelper();

        $rez = $db->select()->from(static::TABLE)->where($column, $value)->get();

        return empty($rez);
        //return $rez;
    }

    public static function count()
    {
        $db = new DBHelper();
        $count = $db->select("count(*)")->from(static::TABLE)->getOne();

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

    public static function exists($id)
    {
        $db = new DBHelper();
        $data = $db->select('id')->from(static::TABLE)->where("id", $id)->getOne();

        return isset($data['id']);
    }
}