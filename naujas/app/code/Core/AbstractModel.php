<?php

namespace Core;

use Helper\DBHelper;

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
}