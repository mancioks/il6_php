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