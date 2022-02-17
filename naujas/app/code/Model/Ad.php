<?php

namespace Model;

use Core\AbstractModel;
use Helper\DBHelper;

class Ad extends AbstractModel
{
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
    private $slug;
    private $createdAt;
    private $vin;
    private $views;


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

    public function __construct()
    {
        $this->table = "ads";
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getSlug()
    {
        if($this->slug)
            return $this->slug;
        else
            return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getVin()
    {
        return $this->vin;
    }

    public function setVin($vin)
    {
        $this->vin = $vin;
    }

    public function getViews()
    {
        return $this->views;
    }

    public function setViews($views)
    {
        $this->views = $views;
    }

    protected function assignData()
    {
        $this->data = [
            'title' => $this->title,
            'description' => $this->description,
            'manufacturer_id' => $this->manufacturerId,
            'model_id' => $this->modelId,
            'price' => $this->price,
            'year' => $this->year,
            'type_id' => $this->typeId,
            'user_id' => $this->userId,
            'image_url' => $this->imageUrl,
            'active' => $this->active,
            'slug' => $this->slug,
            'vin' => $this->vin,
            'views' => $this->views
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from($this->table)->where("id", $id)->getOne();

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
        $this->slug = $data["slug"];
        $this->vin = $data["vin"];
        $this->views = $data["views"];
    }

    public function loadBySlug($slug)
    {
        $db = new DBHelper();
        $data = $db->select("id")->from($this->table)->where("slug", $slug)->getOne();

        if(!empty($data)) {
            $this->load($data["id"]);
        }
    }

    public static function getAll($params = [])
    {
        $db = new DBHelper();

        $db->select("id")->from("ads")->where("active", 1);
        if(isset($params["order_by"]) && isset($params["clause"])) {
            $db->orderBy($params["order_by"], $params["clause"]);
        }
        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = $db->get();

        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element["id"]);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getRelatedAds($currentAd, $params = [])
    {
        $db = new DBHelper();

        $modelId = $currentAd->getModelId();
        $exceptId = $currentAd->getId();

        $db->select("id")
            ->from("ads")
            ->where("active", 1)
            ->andWhere("model_id", $modelId)
            ->andWhere("id", $exceptId, "<>");

        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = $db->get();

        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element["id"]);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function search($search, $params = [])
    {
        $db = new DBHelper();

        $db->select("id")->from("ads")
            ->where("title", "%".$search."%", "LIKE")->andWhere("active", 1)
            ->orWhere("description", "%".$search."%", "LIKE")->andWhere("active", 1);

        if(isset($params["order_by"]) && isset($params["clause"])) {
            $db->orderBy($params["order_by"], $params["clause"]);
        }
        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = $db->get();

        $ads = [];
        foreach ($data as $element) {
            $ad = new Ad();
            $ad->load($element["id"]);
            $ads[] = $ad;
        }

        return $ads;
    }

    public static function getLast()
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("ads")->orderBy("id")->limit(1)->getOne();

        $ad = new Ad();
        $ad->load($data["id"]);

        return $ad;
    }
}