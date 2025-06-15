<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
}

$user = new User();
$users = $user->getAllUsers();
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
        <th>Acties</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= escapeHtml($user['name']) ?></td>
        <td><?= escapeHtml($user['email']) ?></td>
        <td><?= escapeHtml($user['role_name'] ?? 'onbekend') ?></td>
        <td>
            <a href="view.php?id=<?= $user['id'] ?>">Bekijken</a> |
            <a href="edit.php?id=<?= $user['id'] ?>">Bewerken</a> |
            <form action="delete.php" method="post" style="display:inline;" onsubmit="return confirm('Weet je het zeker?');">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <button type="submit">Verwijderen</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'templates/footer.php'; ?>
