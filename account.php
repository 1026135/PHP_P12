<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
    exit;
}

$userObj = new User();
$currentUser = $auth->getUser();
$userData = $userObj->getUserById($currentUser['id']);
$successMessage = '';
$errorMessage = '';

// PROFIEL WIJZIGEN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    if (!empty($name) && !empty($email)) {
        $userObj->updateUser($currentUser['id'], $name, $email);
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        $successMessage = "Profiel succesvol bijgewerkt.";
        $userData = $userObj->getUserById($currentUser['id']);
    } else {
        $errorMessage = "Alle velden zijn verplicht.";
    }
}

// WACHTWOORD WIJZIGEN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_password') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    $stmt = $userObj->pdo->prepare("SELECT password FROM users WHERE id = :id");
    $stmt->execute([':id' => $currentUser['id']]);
    $storedHash = $stmt->fetchColumn();

    if (!password_verify($currentPassword, $storedHash)) {
        $errorMessage = "Huidig wachtwoord is onjuist.";
    } elseif ($newPassword !== $confirmPassword) {
        $errorMessage = "Nieuwe wachtwoorden komen niet overeen.";
    } elseif (strlen($newPassword) < 6) {
        $errorMessage = "Nieuw wachtwoord moet minimaal 6 tekens lang zijn.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $userObj->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $currentUser['id']
        ]);
        $successMessage = "Wachtwoord succesvol gewijzigd.";
    }
}
?>

<?php 
$pageTitle = "Mijn Account";
include 'templates/header.php'; 
?>
<h2>Mijn Account</h2>

<?php if ($successMessage): ?>
    <p style="color: green;"><?= $successMessage ?></p>
<?php endif; ?>
<?php if ($errorMessage): ?>
    <p style="color: red;"><?= $errorMessage ?></p>
<?php endif; ?>

<h3>Profielgegevens</h3>
<form method="post">
    <input type="hidden" name="action" value="update_profile">
    <label>Naam:<br>
        <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>
    </label><br><br>

    <label>Email:<br>
        <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>
    </label><br><br>

    <button type="submit">Profiel opslaan</button>
</form>

<hr>

<h3>Wachtwoord wijzigen</h3>
<form method="post">
    <input type="hidden" name="action" value="update_password">
    
    <label>Huidig wachtwoord:<br>
        <input type="password" name="current_password" required>
    </label><br><br>

    <label>Nieuw wachtwoord:<br>
        <input type="password" name="new_password" required>
    </label><br><br>

    <label>Herhaal nieuw wachtwoord:<br>
        <input type="password" name="confirm_password" required>
    </label><br><br>

    <button type="submit">Wachtwoord opslaan</button>
</form>

<?php include 'templates/footer.php'; ?>
