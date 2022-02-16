<h1>Home page</h1>
<h2>Naujausi skelbimai</h2>
<div class="list-wrapper">
    <ol class="ads-list ads-5">
        <?php foreach ($this->data["new_ads"] as $ad): ?>
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
<h2>Populiariausi skelbimai</h2>
<div class="list-wrapper">
    <ol class="ads-list ads-5">
        <?php foreach ($this->data["popular_ads"] as $ad): ?>
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