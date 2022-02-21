<?php
/**
 * @var \Model\Ad $ad
 */
?>
<table class="standart-table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Year</th>
            <th>Image</th>
            <th>Active</th>
            <th>Vin</th>
            <th>Views</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->data['ads'] as $ad): ?>

            <tr>
                <td><?= $ad->getId(); ?></td>
                <td><?= $ad->getTitle(); ?></td>
                <td>
                    <div class="ad-description">
                        <?= $ad->getDescription(); ?>
                    </div>
                </td>
                <td><?= $ad->getPrice(); ?></td>
                <td><?= $ad->getYear(); ?></td>
                <td>
                    <div class="ad-image">
                        <img src="<?= $ad->getImageUrl(); ?>"/>
                    </div>
                </td>
                <td><?= $ad->getActive(); ?></td>
                <td><?= $ad->getVin(); ?></td>
                <td><?= $ad->getViews(); ?></td>
                <td>
                    <a href="<?= $this->url('admin/adedit', $ad->getId()); ?>">Edit</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>