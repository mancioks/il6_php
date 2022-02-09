<h1>Skelbimai</h1>
<div class="list-wrapper">
    <ol class="ads-list">
        <?php foreach ($this->data['ads'] as $ad): ?>
            <?php if ($ad->getActive() == 1 || $this->isUserLogged() && $ad->getUserId() == $_SESSION["user_id"]): ?>
                <li <?php if($ad->getActive() == 0) echo 'class="inactive-ad"'; ?>>
                    <div class="ad-image-wrapper">
                        <img src="<?php echo $ad->getImageUrl(); ?>"/>
                    </div>
                    <a href="<?php echo BASE_URL; ?>catalog/show/<?php echo $ad->getId(); ?>">
                        <?php echo $ad->getTitle(); ?>
                    </a>
                    <?php if ($this->isUserLogged()): ?>
                        <?php if ($ad->getUserId() == $_SESSION["user_id"]): ?>
                            <a href="<?php echo BASE_URL; ?>catalog/edit/<?php echo $ad->getId(); ?>"
                               class="button-edit">Edit</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</div>