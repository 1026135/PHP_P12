<?php
require_once 'config/config.php';
require_once 'classes/Auth.php';
require_once 'classes/User.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // You might want to add validation here

    $user->updateUser($id, $name, $email);
    header('Location: dashboard.php');
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
            <input type="text" name="name" value="<?= htmlspecialchars($userData['name']) ?>" required>
        </label>
    </p>
    <p>
        <label>Email:<br>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>
        </label>
    </p>
    <p>
        <button type="submit">Opslaan</button>
        <a href="dashboard.php">Annuleren</a>
    </p>
</form>
<?php include 'templates/footer.php'; ?>
