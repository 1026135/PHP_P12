<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
}

$currentUser = $auth->getUser();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    setFlash("Ongeldige aanvraag.", "error");
    redirect('dashboard.php');
}

$userData = new User();
$id = (int)$_POST['id'];

$user = $userData->getUserById($id);

if (!$user) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('dashboard.php');
}

if ($user['id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('dashboard.php');
}

if ($auth->isAdmin() && $user['id'] === $currentUser['id']) {
    setFlash("Admins kunnen hun eigen account niet verwijderen.", "error");
    redirect('dashboard.php');
}

if ($userData->deleteUser($id)) {
    setFlash("Gebruiker succesvol verwijderd.", "success");

    if ($user['id'] === $currentUser['id']) {
        $auth->logout();
        redirect('login.php');
    }
} else {
    setFlash("Fout bij verwijderen van Gebruiker.", "error");
}

redirect('dashboard.php');
?>