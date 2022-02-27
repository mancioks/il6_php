<?php

namespace Helper;

class Messages
{
    private static function initMessages()
    {
        if(!isset($_SESSION["messages"])) {
            $_SESSION["messages"] = [];
        }
    }

    /**
     * @param string $message message to store
     * @param integer $type 0 - error
     *                      1 - warning
     *                      2 - info
     * @return void
     */
    public static function store($message, $type) {
        self::initMessages();

        $cssClass = "message-info";

        if($type == 0) $cssClass = "message-error";
        if($type == 1) $cssClass = "message-warning";
        if($type == 2) $cssClass = "message-info";

        $_SESSION["messages"][] = ["message" => $message, "type" => $type, "class" => $cssClass];
    }

    public static function hasMessages()
    {
        self::initMessages();

        return !empty($_SESSION["messages"]);
    }

    public static function hasErrors()
    {
        self::initMessages();

        $errorFound = false;

        foreach ($_SESSION["messages"] as $message) {
            if($message["type"] == 0)
                $errorFound = true;
        }

        return $errorFound;
    }

    public static function getMessages()
    {
        self::initMessages();

        $messages = $_SESSION["messages"];
        $_SESSION["messages"] = [];

        return !empty($messages) ? $messages : false;
    }
}