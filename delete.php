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

$user = $userDatar->getUserById($id);

if (!$user) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('dashboard.php');
}

if ($user['id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('dashboard.php');
}

if ($productData->deleteProduct($id)) {
    setFlash("Gebruiker succesvol verwijderd.", "success");
} else {
    setFlash("Fout bij verwijderen van Gebruiker.", "error");
}

redirect('dashboard.php');
?>