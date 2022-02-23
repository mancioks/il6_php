<?php

namespace Model;

use Core\AbstractModel;
use Helper\ArrayHelper;
use Helper\DBHelper;

class Comment extends AbstractModel
{
    protected const TABLE = 'comments';
    private $comment;
    private $userId;
    private $adId;
    private $createdAt;

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    public function getAdId()
    {
        return $this->adId;
    }

    public function setAdId($adId): void
    {
        $this->adId = $adId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    protected function assignData()
    {
        $this->data = [
            "comment" => $this->comment,
            "user_id" => $this->userId,
            "ad_id" => $this->adId
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->comment = $data["comment"];
        $this->userId = $data["user_id"];
        $this->adId = $data["ad_id"];
        $this->createdAt = $data["created_at"];
    }

    public static function getCommentsByAdId($adId)
    {
        $db = new DBHelper();
        $data = $db->select("id")->from(self::TABLE)->where("ad_id", $adId)->get();
        $ids = ArrayHelper::rowsToIds($data);

        return self::getCollection($ids);
    }

    public function getUser()
    {
        $user = new User();
        return $user->load($this->userId);
    }

}