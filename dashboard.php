<?php
require_once 'config/config.php';
require_once 'classes/Auth.php';
require_once 'classes/User.php';
require_once 'helpers/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    //header('Location: login.php');
    redirect('login.php');
    exit;
}

$user = new User();
$users = $user->getAllUsers();
?>

<?php 
$pageTitle = "Dashboard";
include 'templates/header.php'; 
?>
<h2>Dashboard</h2>
<p>Welkom, <?= htmlspecialchars($auth->getUser()['name']) ?> | <a href="logout.php">Uitloggen</a></p>

<table border="1">
    <tr>
        <th>Naam</th>
        <th>Email</th>
        <th>Acties</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
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
