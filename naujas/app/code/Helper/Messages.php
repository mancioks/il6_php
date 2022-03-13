<?php

declare(strict_types=1);

namespace Helper;

use Model\Session;

class Messages
{
    private static Session $session;

    private static function initMessages(): void
    {
        self::$session = new Session();

        if(!self::$session->get("messages")) {
            self::$session->set("messages")->value([]);
        }
    }

    /**
     * @param string $message message to store
     * @param integer $type 0 - error
     *                      1 - warning
     *                      2 - info
     * @return void
     */
    public static function store(string $message, int $type): void
    {
        self::initMessages();

        $cssClass = "message-info";

        if($type == 0) $cssClass = "message-error";
        if($type == 1) $cssClass = "message-warning";
        if($type == 2) $cssClass = "message-info";

        self::$session->set("messages")->add(["message" => $message, "type" => $type, "class" => $cssClass]);
    }

    public static function hasMessages(): bool
    {
        self::initMessages();

        return !empty(self::$session->get("messages"));
    }

    public static function hasErrors(): bool
    {
        self::initMessages();

        $errorFound = false;

        foreach (self::$session->get("messages") as $message) {
            if($message["type"] == 0)
                $errorFound = true;
        }

        return $errorFound;
    }

    public static function getMessages(): array|bool
    {
        self::initMessages();

        $messages = self::$session->get("messages");
        self::$session->set("messages")->value([]);

        return !empty($messages) ? $messages : false;
    }
}