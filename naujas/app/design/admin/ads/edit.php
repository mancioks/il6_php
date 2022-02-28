<?php if($this->data["messages"]): ?>
    <ul class="messages">
        <?php foreach ($this->data["messages"] as $message): ?>
            <li class="<?= $message["class"]; ?>"><?= $message["message"]; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<h1>Redagavimas - <?php echo $this->data["ad_title"]; ?></h1>
<div class="form-wrapper">
    <?php echo $this->data["form"]; ?>
</div>