<?php
require_once 'init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
    exit;
}

if (!isset($_GET['id'])) {
    redirect('dashboard.php');
    exit;
}

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // You might want to add validation here

    $user->updateUser($id, $name, $email);
    redirect('dashboard.php');
    exit;
}

$userData = $user->getUserById((int)$_GET['id']);
if (!$userData) {
    echo "Gebruiker niet gevonden.";
    exit;
}
?>

<?php 
$pageTitle = "Edit";
include 'templates/header.php'; 
?>
<h2>Gebruiker Bewerken</h2>
<form action="edit.php?id=<?= $userData['id'] ?>" method="post">
    <input type="hidden" name="id" value="<?= $userData['id'] ?>">
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
        <button type="submit">Opslaan</button>
        <a href="dashboard.php">Annuleren</a>
    </p>
</form>
<?php include 'templates/footer.php'; ?>
