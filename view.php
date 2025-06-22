<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    setFlash("Geen gebruiker geselecteerd.", "error");
    redirect('dashboard.php');
}

$user = new User();
$userData = $user->getUserById((int)$_GET['id']);

if (!$userData) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('dashboard.php');
}
?>


<?php 
$pageTitle = "Gebruiker Details";
include ROOT_PATH . 'templates/header.php'; 
?>
<h2><?= escapeHtml($pageTitle) ?></h2>
<p><a href="<?= url('dashboard.php') ?>">Terug naar dashboard</a></p>

<p><strong>Naam:</strong> <?= escapeHtml($userData['name']) ?></p>
<p><strong>Email:</strong> <?= escapeHtml($userData['email']) ?></p>

<?php include ROOT_PATH . 'templates/footer.php'; ?>