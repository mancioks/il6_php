<?php

namespace Controller;

use Core\AbstractController;
use Core\Interfaces\ControllerInterface;
use Helper\FormHelper;
use Helper\Messages;
use Helper\StringHelper;
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
        $this->data["conversations"] = Message::getConversations($_SESSION["user_id"]);
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

        $form->input([
            "type" => "text",
            "name" => "title",
            "placeholder" => "Pavadinimas"
        ]);
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
        $message->setMessage(StringHelper::filterBadWords($_POST["message"]));
        $message->setSeen(0);
        $message->setToUserId($_POST["to_user_id"]);
        $message->setTitle($_POST["title"]);
        $message->setReplyTo(0);
        $message->save();

        Url::redirect("inbox");
    }

    public function reply()
    {
        $message = new Message();

        $message->setFromUserId($_SESSION["user_id"]);
        $message->setMessage(StringHelper::filterBadWords($_POST["message"]));
        $message->setSeen(0);

        $conversation = new Message();
        $conversation->load($_POST["conversation_id"]);

        if($conversation->getFromUserId() != $_SESSION["user_id"]) {
            $message->setToUserId($conversation->getFromUserId());
        } else {
            $message->setToUserId($conversation->getToUserId());
        }

        $message->setReplyTo($_POST["conversation_id"]);
        $message->setTitle("reply to: ". $conversation->getTitle());

        $message->save();

        Url::redirect("inbox/conversation/".$conversation->getId());
    }

    public function conversation($conversationId)
    {
        $messages = Message::getMessages($conversationId);

        $count = 0;
        if($messages) {
            foreach ($messages as $message) {
                if($message->getSeen() == 0 && $message->getToUserId() == $_SESSION["user_id"]) {
                    $message->setSeen(1);
                    $message->save();
                    $count++;
                }
            }
        }

        $form = new FormHelper("inbox/reply", "POST");
        $form->input([
            "type" => "hidden",
            "name" => "conversation_id",
            "value" => $conversationId
        ]);
        $form->textArea("message", "Atsakymas");
        $form->input([
            "type" => "submit",
            "value" => "Atsakyti",
            "name" => "submit"
        ]);

        $this->data['new_messages'] -= $count;

        $this->data["messages"] = $messages;
        $this->data["reply_form"] = $form->getForm();

        $this->render("inbox/conversation");
    }
}