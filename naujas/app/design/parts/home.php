<h1>Home page</h1>
<div class="ads-slider-wrapper fr-1-5">
    <div class="slider-title">
        <h2>Naujausi skelbimai</h2>
    </div>
    <div class="list-wrapper">
        <ol class="ads-list ads-5">
            <?php foreach ($this->data["new_ads"] as $ad): ?>
                <li>
                    <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                        <div class="ad-image-wrapper">
                            <img src="<?php echo $ad->getImageUrl(); ?>"/>
                        </div>
                        <?php echo $ad->getTitle(); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</div>
<div class="ads-slider-wrapper fr-5-1 blue">
    <div class="list-wrapper">
        <ol class="ads-list ads-5">
            <?php foreach ($this->data["popular_ads"] as $ad): ?>
                <li>
                    <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                        <div class="ad-image-wrapper">
                            <img src="<?php echo $ad->getImageUrl(); ?>"/>
                        </div>
                        <?php echo $ad->getTitle(); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
    <div class="slider-title">
        <h2>Populiariausi skelbimai</h2>
    </div>
</div>