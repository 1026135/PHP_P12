<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om dit te bekijken.", "error");
    redirect('login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setFlash("Geen gebruiker gespecificeerd.", "error");
    redirect('dashboard.php');
}

$currentUser = $auth->getUser();
$userData = new User();
$user = $userData->getUserById($currentUser['id']);

if (!$user) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('dashboard.php');
}

if ($user['id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name)) {
        setFlash("Naam is verplicht.", "error");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash("Ongeldig e-mailadres.", "error");
    } else {
        $existingUser = $userData->getUserByEmail($email);
        if ($existingUser && $existingUser['id'] != $id) {
            setFlash("Dit e-mailadres is al in gebruik.", "error");
        } else {
            if ($userData->updateUser($id, $name, $email)) {
                setFlash("Gebruiker succesvol bijgewerkt.", "success");
                redirect('dashboard.php');
            } else {
                setFlash("Er is een fout opgetreden bij het bijwerken.", "error");
            }
        }
    }
}

?>

<?php 
$pageTitle = "Gebruiker Bewerken";
include ROOT_PATH . 'templates/header.php'; 
?>

<h2><?= escapeHtml($pageTitle) ?></h2>

<form action="<?= url('edit.php?id=' . $user['id']) ?>" method="post">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <p>
        <label>Naam:<br>
            <input type="text" name="name" value="<?= escapeHtml($_POST['name'] ?? $user['name']) ?>" required>
        </label>
    </p>

    <p>
        <label>Email:<br>
            <input type="email" name="email" value="<?= escapeHtml($_POST['email'] ?? $user['email']) ?>" required>
        </label>
    </p>

    <p>
        <button type="submit">Opslaan</button>
        <a href="<?= url('dashboard.php') ?>">Annuleren</a>
    </p>
</form>

<?php include ROOT_PATH . 'templates/footer.php'; ?>
