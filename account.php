<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
    redirect('login.php');
}

$user = new User();
$currentUser = $auth->getUser();

$userData = $user->getUserById($currentUser['id']);
if (!$userData) {
    setFlash("Gebruiker niet gevonden.", "error");
    redirect('login.php');
}

$passwordHash = $user->getPasswordHashByUserId($currentUser['id']);

// Profiel updaten
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name)) {
        setFlash("Naam is verplicht.", "error");
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlash("Een geldig e-mailadres is verplicht.", "error");
    } else {
        $existingUser = $user->getUserByEmail($email);
        if ($existingUser && $existingUser['id'] != $currentUser['id']) {
            setFlash("Dit e-mailadres is al in gebruik.", "error");
        } else {
            if ($user->updateUser($currentUser['id'], $name, $email)) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                setFlash("Profiel succesvol bijgewerkt.", "success");
            } else {
                setFlash("Fout bij bijwerken van profiel.", "error");
            }
        }
    }
    redirect('account.php');
}

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
<h2>Mijn Account</h2>

<h3>Profiel bewerken</h3>
<form method="post">
    <input type="hidden" name="update_profile" value="1">
    <p>
        <label>Naam:<br>
            <input type="text" name="name" value="<?= escapeHtml($userData['name']) ?>" required>
        </label>
    </p>
    <p>
        <label>Email:<br>
            <input type="email" name="email" value="<?= escapeHtml($userData['email']) ?>" required>
        </label>
    </p>
    <p>
        <button type="submit">Profiel opslaan</button>
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
