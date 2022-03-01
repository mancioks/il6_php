<?php

namespace Model;

use Core\AbstractModel;
use Core\Interfaces\ModelInterface;
use Helper\ArrayHelper;
use Helper\DBHelper;

class Message extends AbstractModel implements ModelInterface
{
    private $message;
    private $fromUserId;
    private $toUserId;
    private $seen;
    private $createdAt;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getFromUserId()
    {
        return $this->fromUserId;
    }

    /**
     * @param mixed $fromUserId
     */
    public function setFromUserId($fromUserId): void
    {
        $this->fromUserId = $fromUserId;
    }

    /**
     * @return mixed
     */
    public function getToUserId()
    {
        return $this->toUserId;
    }

    /**
     * @param mixed $toUserId
     */
    public function setToUserId($toUserId): void
    {
        $this->toUserId = $toUserId;
    }

    /**
     * @return mixed
     */
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * @param mixed $seen
     */
    public function setSeen($seen): void
    {
        $this->seen = $seen;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public const TABLE = 'inbox';

    public function assignData()
    {
        $this->data = [
            'message' => $this->message,
            'from_user_id' => $this->fromUserId,
            'to_user_id' => $this->toUserId,
            'seen' => $this->seen
        ];
    }

    public function load($id)
    {
        $db = new DBHelper();
        $data = $db->select()->from(self::TABLE)->where("id", $id)->getOne();

        $this->id = $data["id"];
        $this->message = $data["message"];
        $this->fromUserId = $data["from_user_id"];
        $this->toUserId = $data["to_user_id"];
        $this->seen = $data["seen"];
        $this->createdAt = $data["created_at"];
    }

    /**
     * @param int $userId user id
     * @param string $type received|sent
     * @return void
     */
    public static function getMessages($userId, $type)
    {
        $db = new DBHelper();
        $db->select("id")->from(self::TABLE);
        if($type == "received") {
            $db->where("to_user_id", $userId);
        }
        if($type == "sent") {
            $db->where("from_user_id", $userId);
        }
        $ids = $db->get();
        $ids = ArrayHelper::rowsToIds($ids);

        return Message::getCollection($ids);
    }

    public function getFromUser()
    {
        $user = new User();
        return $user->load($this->fromUserId);
    }

    public function getToUser()
    {
        $user = new User();
        return $user->load($this->toUserId);
    }

    public static function newMessagesCount()
    {
        $db = new DBHelper();
        $db->select("count(*)")
            ->from(self::TABLE)
            ->where("to_user_id", $_SESSION["user_id"])
            ->andWhere("seen", "0");
        $data = $db->getOne();

        return $data[0];
    }
}