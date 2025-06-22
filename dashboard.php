<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
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
include ROOT_PATH . 'templates/header.php';
?>
<h2><?= escapeHtml($pageTitle) ?></h2>
<p>
    Welkom, <?= escapeHtml($auth->getUser()['name']) ?> | 
    <a href="<?= url('account.php') ?>">Mijn account</a> | 
    <a href="<?= url('logout.php') ?>">Uitloggen</a>
</p>

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
                    <form action="<?= url('changerole.php') ?>" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <select name="role" onchange="this.form.submit()">
                            <option value="user" <?= $user['role_name'] === 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= $user['role_name'] === 'admin' ?  'selected' : '' ?>>Admin</option>
                        </select>
                    </form>
                <?php endif; ?>

                <a href="<?= url('view.php?id=' . $user['id']) ?>">Bekijken</a> |
                <a href="<?= url('edit.php?id=' . $user['id']) ?>">Bewerken</a> |

                <form action="<?= url('delete.php') ?>" method="post" style="display:inline;" onsubmit="return confirm('Weet je het zeker?');">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; padding:0; font:inherit;">Verwijderen</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include ROOT_PATH . 'templates/footer.php'; ?>
