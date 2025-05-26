<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
    exit;
}

if (!isset($_GET['id'])) {
    redirect('dashboard.php');
    exit;
}

$user = new User();
$userData = $user->getUserById((int)$_GET['id']);

if (!$userData) {
    echo "Gebruiker niet gevonden.";
    exit;
}
?>

<?php 
$pageTitle = "View";
include 'templates/header.php'; 
?>
<h2>Gebruiker Details</h2>
<p><a href="dashboard.php">Terug naar dashboard</a></p>

<p><strong>Naam:</strong> <?= escapeHtml($userData['name']) ?></p>
<p><strong>Email:</strong> <?= escapeHtml($userData['email']) ?></p>

<?php include 'templates/footer.php'; ?>
