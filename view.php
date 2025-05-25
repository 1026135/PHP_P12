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

if (!isset($_GET['id'])) {
    //header('Location: dashboard.php');
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

<p><strong>Naam:</strong> <?= htmlspecialchars($userData['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>

<?php include 'templates/footer.php'; ?>
