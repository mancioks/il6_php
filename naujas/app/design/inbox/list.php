<h1>Gautos žinutės</h1>
<a href="<?= $this->url("inbox/create") ?>">Rašyti</a>
<a href="<?= $this->url("inbox/sent") ?>">Išsiųstos žinutės</a>
<?php if($this->data["messages"]): ?>
    <div class="messages-wrapper">
        <?php foreach ($this->data["messages"] as $message): ?>
            <div class="message">
                <div class="message-user"><b>Siuntėjas</b>: <?= $message->getFromUser()->getName() . " ". $message->getFromUser()->getLastName(); ?></div>
                <div class="message-text"><?= $message->getMessage(); ?></div>
                <div class="message-date"><?= $message->getCreatedAt(); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-list-wrapper">
        Gautų žinučių nėra
    </div>
<?php endif; ?>