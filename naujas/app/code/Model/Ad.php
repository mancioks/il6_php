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
    private $imageUrl;
    private $active;

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
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    public function setActive($active)
    {
        $this->active = $active;
    }
    public function getActive()
    {
        return $this->active;
    }

    public function load($id) {
        $db = new DBHelper();
        $data = $db->select()->from("ads")->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->manufacturerId = $data["manufacturer_id"];
        $this->modelId = $data["model_id"];
        $this->price = $data["price"];
        $this->year = $data["year"];
        $this->typeId = $data["type_id"];
        $this->userId = $data["user_id"];
        $this->imageUrl = $data["image_url"];
        $this->active = $data["active"];
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
            'user_id'=>$this->userId,
            'image_url'=>$this->imageUrl,
            'active'=>$this->active
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
            'user_id'=>$this->userId,
            'image_url'=>$this->imageUrl,
            'active'=>$this->active
        ];

        $db->insert("ads", $data)->exec();
    }

    public static function getAll()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("ads")->get();

        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element["id"]);
            $ads[] = $ad;
        }

        return $ads;
    }
}