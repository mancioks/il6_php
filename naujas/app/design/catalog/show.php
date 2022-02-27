<div class="ad-wrapper">
    <h1><?php echo $this->data['ad']->getTitle(); ?></h1>
    <div class="ad-image-wrapper">
        <img src="<?php echo $this->data['ad']->getImageUrl(); ?>"/>
    </div>
    <p><?php echo $this->data['ad']->getDescription(); ?></p>
    <div class="ad-price"><?php echo $this->data['ad']->getPrice(); ?>€</div>
    <div class="ad-year"><?php echo $this->data['ad']->getYear(); ?></div>
    <?php echo $this->data['ad']->getVin(); ?>
</div>
<div class="comments-wrapper">
    <?php if($this->data["messages"]): ?>
        <ul class="messages">
            <?php foreach ($this->data["messages"] as $message): ?>
                <li class="<?= $message["class"]; ?>"><?= $message["message"]; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <h2>Komentarai</h2>
    <?php
    /**
     * @var \Model\Comment $comment
     */
    ?>
    <ul>
        <?php foreach ($this->data['ad']->getComments() as $comment): ?>
            <li>
                <div class="comment">
                    <div class="comment-user"><?= $comment->getUser()->getEmail(); ?></div>
                    <div class="comment-date"><?= $comment->getCreatedAt(); ?></div>
                    <div class="comment-comment"><?= $comment->getComment(); ?></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($this->isUserLogged()): ?>
        <div class="comment-form-wrapper">
            <?= $this->data["comment_form"]; ?>
        </div>
    <?php endif; ?>
</div>
<?php if($this->data["has_related_ads"]): ?>
    <h2>Panašūs skelbimai</h2>
    <div class="list-wrapper">
        <ol class="ads-list ads-5">
            <?php foreach ($this->data["related_ads"] as $ad): ?>
                <li>
                    <div class="ad-image-wrapper">
                        <img src="<?php echo $ad->getImageUrl(); ?>"/>
                    </div>
                    <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                        <?php echo $ad->getTitle(); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php endif; ?>
