<?php

namespace Model;

use Core\AbstractModel;

class Comment extends AbstractModel
{
    protected const TABLE = 'comments';
    private $comment;
    private $user_id;
    private $ad_id;
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
        return $this->user_id;
    }

    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getAdId()
    {
        return $this->ad_id;
    }

    public function setAdId($ad_id): void
    {
        $this->ad_id = $ad_id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    protected function assignData()
    {
        $this->data = [
            "comment" => $this->comment,
            "user_id" => $this->user_id,
            "ad_id" => $this->ad_id,
            "created_at" => $this->createdAt
        ];
    }

}