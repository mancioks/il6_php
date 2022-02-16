<h1>Skelbimai</h1>
<div class="search-wrapper">
    <?php echo $this->data["search_form"]; ?>
</div>
<div class="order-wrapper">
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=id&clause=ASC">Numatytasis rikiavimas</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=created_at&clause=ASC">Seniausi pirmiau</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=created_at&clause=DESC">Naujausi pirmiau</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=price&clause=ASC">Pigiausi pirmiau</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=price&clause=DESC">Brangiausi pirmiau</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=title&clause=ASC">Pavadinimas a-z</a>
    <a href="<?php echo $this->url("catalog/all"); ?>?order_by=title&clause=DESC">Pavadinimas z-a</a>
</div>
<div class="list-wrapper">
    <ol class="ads-list">
        <?php foreach ($this->data['ads'] as $ad): ?>
            <?php if ($ad->getActive() == 1 || $this->isUserLogged() && $ad->getUserId() == $_SESSION["user_id"]): ?>
                <li <?php if($ad->getActive() == 0) echo 'class="inactive-ad"'; ?>>
                    <div class="ad-image-wrapper">
                        <img src="<?php echo $ad->getImageUrl(); ?>"/>
                    </div>
                    <a href="<?php echo $this->url("catalog/show", $ad->getSlug()) ?>">
                        <?php echo $ad->getTitle(); ?>
                    </a>
                    <?php if ($this->isUserLogged()): ?>
                        <?php if ($ad->getUserId() == $_SESSION["user_id"]): ?>
                            <a href="<?php echo $this->url("catalog/edit", $ad->getId()) ?>"
                               class="button-edit">Edit</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ol>
</div>