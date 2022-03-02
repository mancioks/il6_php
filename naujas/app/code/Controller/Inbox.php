<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Messages;
use Helper\Url;
use Model\Message;
use Model\User;

class Inbox extends AbstractController implements ControllerInterface
{
    public function __construct() {
        parent::__construct();
        if(!$this->isUserLogged()) {
            Url::redirect("user/login");
        }
    }
    public function index()
    {
        $messages = Message::getMessages($_SESSION["user_id"], "received");

        if($messages) {
            foreach ($messages as $message) {
                $message->setSeen(1);
                $message->save();
            }
        }

        $this->data["messages"] = $messages;
        $this->render("inbox/list");
    }

    public function create($to = null)
    {
        $form = new FormHelper("inbox/send", "post");

        $usersList = [];
        $users = User::getAll();
        foreach ($users as $user) {
            if($user->getId() != $_SESSION["user_id"]) {
                $usersList[$user->getId()] = $user->getName(). " " .$user->getLastName();
            }
        }

        $form->label("Gavėjas");
        $form->select([
            "name" => "to_user_id",
            "options" => $usersList,
            "selected" => $to,
            "id" => "user_id"
        ]);
        $form->label("Žinutė");
        $form->textArea("message", "Žinutė");
        $form->input([
            "type" => "submit",
            "value" => "Rašyti",
            "name" => "submit"
        ]);

        $this->data["form"] = $form->getForm();

        $this->render("inbox/create");
    }

    public function send()
    {
        $message = new Message();
        $message->setFromUserId($_SESSION["user_id"]);
        $message->setToUserId($_POST["to_user_id"]);
        $message->setMessage($_POST["message"]);
        $message->setSeen(0);

        $message->save();

        Url::redirect("inbox/sent");
    }

    public function sent()
    {
        $this->data["messages"] = Message::getMessages($_SESSION["user_id"], "sent");
        $this->render("inbox/sent");
    }
}