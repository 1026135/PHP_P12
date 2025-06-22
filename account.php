<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
    redirect('login.php');
}


$currentUser = $auth->getUser();
$userData = new User();
$user = $userData->getUserById($currentUser['id']);

if (!$user) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('login.php');
}

if ($user['id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('dashboard.php');
}

// Profiel updaten
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
                redirect('account.php');
            } else {
                setFlash("Er is een fout opgetreden bij het bijwerken.", "error");
            }
        }
    }
}

$passwordHash = $userData->getPasswordHashByUserId($currentUser['id']);

// Wachtwoord wijzigen
if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        setFlash("Vul alle velden voor wachtwoordwijziging in.", "error");
    } elseif (!password_verify($currentPassword, $passwordHash)) {
        setFlash("Huidig wachtwoord is onjuist.", "error");
    } elseif ($newPassword !== $confirmPassword) {
        setFlash("Nieuwe wachtwoorden komen niet overeen.", "error");
    } elseif (strlen($newPassword) < 4) {
        setFlash("Nieuw wachtwoord moet minimaal 4 tekens lang zijn.", "error");
    } else {
        if ($user->updatePassword($currentUser['id'], $newPassword)) {
            $passwordHash = $user->getPasswordHashByUserId($currentUser['id']);
            setFlash("Wachtwoord succesvol gewijzigd.", "success");
        } else {
            setFlash("Fout bij wijzigen van wachtwoord.", "error");
        }
    }
    redirect('account.php');
}
?>

<?php 
$pageTitle = "Mijn Account";
include ROOT_PATH . 'templates/header.php';
?>
<h2><?= escapeHtml($pageTitle) ?></h2>

<h3>Profiel bewerken</h3>
<form action="<?= url('account.php?id=' . $user['id']) ?>" method="post">
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

<hr>

<h3>Wachtwoord wijzigen</h3>
<form method="post">
    <input type="hidden" name="change_password" value="1">
    <p>
        <label>Huidig wachtwoord:<br>
            <input type="password" name="current_password" required>
        </label>
    </p>
    <p>
        <label>Nieuw wachtwoord:<br>
            <input type="password" name="new_password" required>
        </label>
    </p>
    <p>
        <label>Bevestig nieuw wachtwoord:<br>
            <input type="password" name="confirm_password" required>
        </label>
    </p>
    <p>
        <button type="submit">Wachtwoord wijzigen</button>
    </p>
</form>

<?php include ROOT_PATH . 'templates/footer.php'; ?>
