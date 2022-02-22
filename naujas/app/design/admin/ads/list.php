<?php
/**
 * @var \Model\Ad $ad
 */
?>
<form action="<?= $this->url("admin/editselectedads") ?>" method="post">
    Pažymėtus:
    <select name="with_selected">
        <option value="activate">Aktyvuoti</option>
        <option value="deactivate">Deaktyvuoti</option>
    </select>
    <input type="submit" value="Vykdyti" name="submit"/>
    <table class="standart-table">
        <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Year</th>
                <th>Image</th>
                <th>Active</th>
                <th>Vin</th>
                <th>Views</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($this->data['ads'] as $ad): ?>

                <tr>
                    <td><input type="checkbox" name="checked_ads[]" value="<?= $ad->getId(); ?>"/></td>
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
                    <td><?= $ad->getUser()->getEmail(); ?></td>
                    <td>
                        <a href="<?= $this->url('admin/adedit', $ad->getId()); ?>">Edit</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</form>