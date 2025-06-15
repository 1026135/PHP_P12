<?php
require_once 'init.php';

$auth = new Auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($auth->login($email, $password)) {
        setFlash("Welkom terug!", "success");
        redirect('dashboard.php');
        exit;
    } else {
        setFlash("Ongeldige inloggegevens.", "error");
        redirect('login.php');
        exit;
    }
}
?>

<?php 
$pageTitle = "Login";
include 'templates/header.php'; 
?>
<h2>Login</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Wachtwoord:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Inloggen</button>
</form>
<?php include 'templates/footer.php'; ?>
