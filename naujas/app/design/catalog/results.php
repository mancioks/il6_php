<h1>Rezultatai <?php echo $this->data['search_query']; ?> (<?php echo $this->data['quantity']; ?>):</h1>
<div class="list-wrapper">
    <ol class="ads-list">
        <?php if (!empty($this->data['ads'])): ?>
            <?php foreach ($this->data['ads'] as $ad): ?>
                <?php if ($ad->getActive() == 1 || $this->isUserLogged() && $ad->getUserId() == $this->session->get("user_id")): ?>
                    <li <?php if ($ad->getActive() == 0) echo 'class="inactive-ad"'; ?>>
                        <div class="ad-image-wrapper">
                            <img src="<?php echo $ad->getImageUrl(); ?>"/>
                        </div>
                        <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                            <?php echo $ad->getTitle(); ?>
                        </a>
                        <?php if ($this->isUserLogged()): ?>
                            <?php if ($ad->getUserId() == $this->session->get("user_id")): ?>
                                <a href="<?php echo $this->url("catalog/edit", $ad->getId()) ?>"
                                   class="button-edit">Edit</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="search-empty">Skelbimų nerasta</div>
        <?php endif; ?>
    </ol>
</div>