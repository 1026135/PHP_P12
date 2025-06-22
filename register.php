<?php
require_once 'init.php';

$auth = new Auth();
$user = new User();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($user->emailExists($email)) {
        setFlash("E-mailadres bestaat al.", "error");
        redirect('register.php');
    } else {
        $user->addUser($name, $email, $password);
        setFlash("Registratie succesvol! Je kunt nu inloggen.", "success");
        redirect('login.php');
    }
}
?>

<?php 
$pageTitle = "Register";
include ROOT_PATH . 'templates/header.php'; 
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
<?php include ROOT_PATH . 'templates/footer.php'; ?>
