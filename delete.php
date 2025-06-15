<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user = new User();
    $id = (int)$_POST['id'];

    // (optioneel) controleer of gebruiker bestaat
    if ($user->getUserById($id)) {
        $user->deleteUser($id);
        setFlash("Gebruiker succesvol verwijderd.", "success");
    } else {
        setFlash("Gebruiker niet gevonden.", "error");
    }
} else {
    setFlash("Ongeldige aanvraag.", "error");
}

redirect('dashboard.php');
exit;
?>