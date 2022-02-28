<h1>Mano skelbimai</h1>
<?php if($this->data['ads']): ?>
    <div class="list-wrapper">
        <ol class="ads-list">
            <?php foreach ($this->data['ads'] as $ad): ?>
                <li <?php if($ad->getActive() == 0) echo 'class="inactive-ad"'; ?>>
                    <div class="ad-image-wrapper">
                        <img src="<?php echo $ad->getImageUrl(); ?>"/>
                    </div>
                    <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                        <?php echo $ad->getTitle(); ?>
                    </a>
                    <a href="<?php echo $this->url("catalog/edit", $ad->getId()) ?>" class="button-edit">Edit</a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
<?php else: ?>
    <div class="empty-list-wrapper">
        Skelbimų nėra, <a href="<?= $this->url("catalog/create"); ?>">pridėkite!</a>
    </div>
<?php endif; ?>