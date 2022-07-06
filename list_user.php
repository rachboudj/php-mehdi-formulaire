<?php
require('includes/pdo.php');
require('includes/function.php');
$title = "Contact";
// Get all beers
$sql = "SELECT * FROM users ORDER BY created_at ASC";
$query = $pdo->prepare($sql);
$query->execute();
// fetchAll, fetch , fetchColumn
$users = $query->fetchAll();
// debug($users);
?>

<?php 
include('includes/header.php');
?>

<h1>Les utilisateurs</h1>
<table>
    <thead>
        <tr>
            <th>id</th>
            <th>nom</th>
            <th>prenom</th>
            <th>email</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?= $user['id']; ?></td>
                <td><?= $user['nom']; ?></td>
                <td><?= $user['prenom']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><a href="edit_user.php?id=<?= $user['id'] ?>">Éditer</a></td>
                <td><a href="supp_user.php?id=<?= $user['id'] ?>">Supprimer</a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include('includes/footer.php');
