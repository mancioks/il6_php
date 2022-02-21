<?php
/**
 * @var \Model\User $user
 */
?>
<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->data['users'] as $user): ?>

        <tr>
            <td><?= $user->getId(); ?></td>
            <td><?= $user->getName(); ?></td>
            <td><?= $user->getLastName(); ?></td>
            <td><?= $user->getEmail(); ?></td>
            <td><?= $user->getPhone(); ?></td>
            <td><?= $user->getActive(); ?></td>
            <td>
                <a href="<?= $this->url('admin/useredit', $user->getId()); ?>">Edit</a>
            </td>
        </tr>

        <?php endforeach; ?>
    </tbody>
</table>