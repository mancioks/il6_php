<h1>Vartotojai</h1>
<div class="list-wrapper">
    <ol>
        <?php foreach ($this->data['users'] as $user): ?>

            <li>
                <a href="<?php echo $this->url("user/show", $user->getId()) ?>">
                    <?php echo $user->getName(); ?> <?php echo $user->getLastName(); ?>
                </a>
            </li>

        <?php endforeach; ?>
    </ol>
</div>