<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
}

if (!$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'], $_POST['role'])) {
    setFlash("Ongeldige aanvraag.", "error");
    redirect('dashboard.php');
}

$userData = new User();
$id = (int)$_POST['id'];
$newRole = trim($_POST['role']);

$allowedRoles = ['user', 'admin'];

if (!in_array($newRole, $allowedRoles)) {
    setFlash("Ongeldige rol geselecteerd.", "error");
    redirect('dashboard.php');
}

$user = $userData->getUserById($id);

if (!$user) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('dashboard.php');
}

$currentUser = $auth->getUser();
if ($currentUser['id'] === $id && $newRole !== 'admin') {
    setFlash("Je kunt jezelf niet demoten.", "error");
    redirect('dashboard.php');
}

if ($userData->updateUserRole($id, $newRole)) {
    setFlash("Rol succesvol bijgewerkt.", "success");
} else {
    setFlash("Fout bij bijwerken van rol.", "error");
}

redirect('dashboard.php');
