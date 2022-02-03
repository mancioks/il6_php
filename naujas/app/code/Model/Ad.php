<?php

namespace Model;

use Helper\DBHelper;

class Ad
{
    private $id;
    private $title;
    private $description;
    private $manufacturerId;
    private $modelId;
    private $price;
    private $year;
    private $typeId;
    private $userId;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getManufacturerId()
    {
        return $this->manufacturerId;
    }

    /**
     * @param mixed $manufacturerId
     */
    public function setManufacturerId($manufacturerId)
    {
        $this->manufacturerId = $manufacturerId;
    }

    /**
     * @return mixed
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param mixed $modelId
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param mixed $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function load($id) {
        $db = new DBHelper();
        $data = $db->select()->from("ads")->getOne();

        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->manufacturerId = $data["manufacturer_id"];
        $this->modelId = $data["model_id"];
        $this->price = $data["price"];
        $this->year = $data["year"];
        $this->typeId = $data["type_id"];
        $this->userId = $data["user_id"];
    }

    public function save() {
        if(isset($this->id)) {
            $this->update();
        } else {
            $this->create();
        }
    }

    private function update() {
        $db = new DBHelper();

        $data = [
            'title'=>$this->title,
            'description' => $this->description,
            'manufacturer_id'=>$this->manufacturerId,
            'model_id'=>$this->modelId,
            'price'=>$this->price,
            'year'=>$this->year,
            'type_id'=>$this->typeId,
            'user_id'=>$this->userId
        ];

        $db->update("ads", $data)->where('id', $this->id)->exec();
    }

    private function create() {
        $db = new DBHelper();

        $data = [
            'title'=>$this->title,
            'description' => $this->description,
            'manufacturer_id'=>$this->manufacturerId,
            'model_id'=>$this->modelId,
            'price'=>$this->price,
            'year'=>$this->year,
            'type_id'=>$this->typeId,
            'user_id'=>$this->userId
        ];

        $db->insert("ads", $data)->exec();
    }
}