<?php

declare(strict_types=1);

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\ArrayHelper;
use Helper\DBHelper;

class Ad extends AbstractModel implements ModelInterface
{
    private string $title;
    private string $description;
    private int $manufacturerId;
    private int $modelId;
    private float $price;
    private int $year;
    private int $typeId;
    private int $userId;
    private string $imageUrl;
    private bool $active;
    private string $slug;
    private string $createdAt;
    private string $vin;
    private int $views;

    public const TABLE = 'ads';

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getManufacturerId(): int
    {
        return $this->manufacturerId;
    }

    public function setManufacturerId(int $manufacturerId): void
    {
        $this->manufacturerId = $manufacturerId;
    }

    public function getModelId(): int
    {
        return $this->modelId;
    }

    public function setModelId(int $modelId): void
    {
        $this->modelId = $modelId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId): void
    {
        $this->typeId = $typeId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function setImageUrl(string $imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function setVin(string $vin): void
    {
        $this->vin = $vin;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): void
    {
        $this->views = $views;
    }

    public function assignData(): void
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

    public function load(int $id): void
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->description = $data["description"];
        $this->manufacturerId = $data["manufacturer_id"];
        $this->modelId = $data["model_id"];
        $this->price = $data["price"];
        $this->year = (int)$data["year"];
        $this->typeId = $data["type_id"];
        $this->userId = $data["user_id"];
        $this->imageUrl = $data["image_url"];
        $this->active = (bool)$data["active"];
        $this->slug = $data["slug"];
        $this->vin = $data["vin"];
        $this->views = $data["views"];
        $this->createdAt = $data["created_at"];
    }

    public function loadBySlug(string $slug): void
    {
        $db = new DBHelper();
        $data = $db->select("id")->from(self::TABLE)->where("slug", $slug)->getOne();

        if(!empty($data)) {
            $this->load($data["id"]);
        }
    }

    public static function getAll(array $params = [], bool $withDeactivated = false): array
    {
        $db = new DBHelper();

        $db->select("id")->from(self::TABLE);
        if(!$withDeactivated) {
            $db->where("active", 1);
        }
        if(isset($params["order_by"]) && isset($params["clause"])) {
            $db->orderBy($params["order_by"], $params["clause"]);
        }
        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = ArrayHelper::rowsToIds($db->get());

        return Ad::getCollection($data);
    }

    public static function getRelatedAds(Ad $currentAd, array $params = []): array
    {
        $db = new DBHelper();

        $modelId = $currentAd->getModelId();
        $exceptId = $currentAd->getId();

        $db->select("id")
            ->from(self::TABLE)
            ->where("active", 1)
            ->andWhere("model_id", $modelId)
            ->andWhere("id", $exceptId, "<>");

        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = ArrayHelper::rowsToIds($db->get());

        return Ad::getCollection($data);
    }

    public static function search(string $search, array $params = []): array
    {
        $db = new DBHelper();

        $db->select("id")->from(self::TABLE)
            ->where("title", "%".$search."%", "LIKE")->andWhere("active", 1)
            ->orWhere("description", "%".$search."%", "LIKE")->andWhere("active", 1);

        if(isset($params["order_by"]) && isset($params["clause"])) {
            $db->orderBy($params["order_by"], $params["clause"]);
        }
        if(isset($params["limit"])) {
            $db->limit($params["limit"]);
        }
        $data = ArrayHelper::rowsToIds($db->get());

        return Ad::getCollection($data);
    }

    public static function getLast(): Ad
    {
        $db = new DBHelper();
        $data = $db->select("id")->from(self::TABLE)->orderBy("id")->limit(1)->getOne();

        $ad = new Ad();
        $ad->load($data["id"]);

        return $ad;
    }

    public function getUser(): User
    {
        $db = new DBHelper();
        $data = $db->select("id")->from("users")->where("id", $this->userId)->getOne();
        $user = new User();

        return $user->load($data["id"]);
    }

    public function getComments(): array
    {
        return Comment::getCommentsByAdId($this->id);
    }

}