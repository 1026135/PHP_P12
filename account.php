<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$userObj = new User();
$currentUser = $auth->getUser();

$userData = $userObj->getUserById($currentUser['id']);
if (!$userData) {
    echo "Gebruiker niet gevonden.";
    exit;
}

// Get the hashed password separately
$passwordHash = $userObj->getPasswordHashByUserId($currentUser['id']);

$errors = [];
$success = '';

// Profiel updaten
if (isset($_POST['update_profile'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Simpele validaties
    if (empty($name)) {
        $errors[] = "Naam is verplicht.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Een geldig e-mailadres is verplicht.";
    }
    // Check of email al in gebruik is door een andere gebruiker
    $existingUser = $userObj->getUserByEmail($email);
    if ($existingUser && $existingUser['id'] != $currentUser['id']) {
        $errors[] = "Dit e-mailadres is al in gebruik.";
    }

    if (empty($errors)) {
        if ($userObj->updateUser($currentUser['id'], $name, $email)) {
            $success = "Profiel succesvol bijgewerkt.";
            // Update sessie naam en email
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['email'] = $email;
            // Refresh data
            $userData = $userObj->getUserById($currentUser['id']);
        } else {
            $errors[] = "Er is een fout opgetreden bij het bijwerken van het profiel.";
        }
    }
}

// Wachtwoord wijzigen
if (isset($_POST['change_password'])) {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $errors[] = "Vul alle velden voor wachtwoordwijziging in.";
    } else {
        // Check huidig wachtwoord
        if (!password_verify($currentPassword, $passwordHash)) {
            $errors[] = "Huidig wachtwoord is onjuist.";
        } elseif ($newPassword !== $confirmPassword) {
            $errors[] = "Nieuwe wachtwoorden komen niet overeen.";
        } elseif (strlen($newPassword) < 6) {
            $errors[] = "Nieuw wachtwoord moet minimaal 6 tekens lang zijn.";
        } else {
            if ($userObj->updatePassword($currentUser['id'], $newPassword)) {
                $success = "Wachtwoord succesvol gewijzigd.";
                // Refresh the password hash after update
                $passwordHash = $userObj->getPasswordHashByUserId($currentUser['id']);
            } else {
                $errors[] = "Er is een fout opgetreden bij het wijzigen van het wachtwoord.";
            }
        }
    }
}

function escapeHtml($string) {
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

?>

<?php 
$pageTitle = "Mijn Account";
include 'templates/header.php'; 
?>

<h2>Mijn Account</h2>

<?php if (!empty($errors)): ?>
    <div style="color:red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= escapeHtml($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <p style="color:green;"><?= escapeHtml($success) ?></p>
<?php endif; ?>

<!-- Profiel formulier -->
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

<!-- Wachtwoord wijzigen formulier -->
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

<?php include 'templates/footer.php'; ?>
