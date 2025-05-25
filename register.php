<?php
require 'config/config.php';
require 'classes/User.php';

$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($user->emailExists($email)) {
        $error = "E-mailadres bestaat al.";
    } else {
        $user->addUser($name, $email, $password);
        header('Location: login.php');
        exit;
    }
}
?>

<?php 
$pageTitle = "Register";
include 'templates/header.php'; 
?>
<h2>Registreren</h2>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
    <label>Naam:</label><br>
    <input type="text" name="name" required><br>
    <label>Email:</label><br>
    <input type="email" name="email" required><br>
    <label>Wachtwoord:</label><br>
    <input type="password" name="password" required><br>
    <button type="submit">Registreren</button>
</form>
<?php include 'templates/footer.php'; ?>
