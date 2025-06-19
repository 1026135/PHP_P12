<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
}

$user = new User();
$currentUser = $auth->getUser();

if ($auth->isAdmin()) {
    $users = $user->getAllUsers();
} else {
    $users = [$user->getUserById($currentUser['id'])];
}

?>

<?php 
$pageTitle = "Dashboard";
include 'templates/header.php';
?>
<h2>Dashboard</h2>
<p>Welkom, <?= escapeHtml($auth->getUser()['name']) ?> | <a href="account.php">Mijn account</a> | <a href="logout.php">Uitloggen</a> </p>

<table border="1">
    <tr>
        <th>Naam</th>
        <th>Email</th>
        <th>Rol</th>
        <th style="text-align: center;">Acties</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= escapeHtml($user['name']) ?></td>
        <td><?= escapeHtml($user['email']) ?></td>
        <td><?= escapeHtml($user['role_name'] ?? 'onbekend') ?></td>
        <td style="text-align: center; white-space: nowrap;">
            <?php if ($auth->isAdmin()): ?>
                <a href="changerole.php?id=<?= $user['id'] ?>">Rol wijzigen</a> |
            <?php endif; ?>
            <a href="view.php?id=<?= $user['id'] ?>">Bekijken</a> |
            <a href="edit.php?id=<?= $user['id'] ?>">Bewerken</a> |
            <form action="delete.php" method="post" style="display:inline;" onsubmit="return confirm('Weet je het zeker?');">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; padding:0; font:inherit;">Verwijderen</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'templates/footer.php'; ?>
