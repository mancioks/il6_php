<h1>Žinutės</h1>
<a href="<?= $this->url("inbox/create") ?>">Rašyti</a>
<?php if($this->data["conversations"]): ?>
    <div class="messages-wrapper">
        <?php foreach ($this->data["conversations"] as $message): ?>
            <a href="<?= $this->url("inbox/conversation", $message->getId()); ?>">
                <div class="message <?php if($message->newMessagesInConversation($this->session->get("user_id")) > 0) echo "has-new-messages"; ?>">
                    <div class="message-title"><?= $message->getTitle(); ?></div>
                    <div class="message-users">
                        Pokalbio dalyviai: <?= $message->getFromUser()->getName(); ?>, <?= $message->getToUser()->getName(); ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-list-wrapper">
        Žinučių nėra
    </div>
<?php endif; ?>