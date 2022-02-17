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
