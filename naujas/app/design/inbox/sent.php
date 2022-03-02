<h1>Išsiųstos žinutės</h1>
<a href="<?= $this->url("inbox/create") ?>">Rašyti</a>
<a href="<?= $this->url("inbox") ?>">Gautos žinutės</a>
<?php if($this->data["messages"]): ?>
    <div class="messages-wrapper">
        <?php foreach ($this->data["messages"] as $message): ?>
            <div class="message">
                <div class="message-user"><b>Gavėjas</b>: <?= $message->getToUser()->getName() . " ". $message->getToUser()->getLastName(); ?></div>
                <div class="message-text"><?= $message->getMessage(); ?></div>
                <div class="message-date"><?= $message->getCreatedAt(); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="empty-list-wrapper">
        Išsiųstų žinučių nėra, <a href="<?= $this->url("inbox/create") ?>">rašyti</a>
    </div>
<?php endif; ?>