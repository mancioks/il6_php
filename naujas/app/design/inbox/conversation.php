<h1>Pokalbis</h1>
<?php if($this->data["messages"]): ?>
    <div class="conversation-users">
        Pokalbio dalyviai: <?= $this->data["messages"][0]->getFromUser()->getName(); ?>, <?= $this->data["messages"][0]->getToUser()->getName(); ?>
    </div>
    <div class="conversation-wrapper">
        <?php foreach ($this->data["messages"] as $message): ?>
            <div class="conversation-message-wrapper">
                <div class="message <?php if($message->getFromUserId() == $this->session->get("user_id")){echo "own-message";} ?>">
                    <div class="message-user"><?= $message->getFromUser()->getName() . " ". $message->getFromUser()->getLastName(); ?></div>
                    <div class="message-text"><?= $message->getMessage(); ?></div>
                    <div class="message-date"><?= $message->getCreatedAt(); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="reply-form-wrapper">
        <?= $this->data["reply_form"]; ?>
    </div>
<?php endif; ?>