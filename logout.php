<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();
$auth->logout();

setFlash("Je bent succesvol uitgelogd.", "info");
redirect('login.php');
?>

