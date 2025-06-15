<?php
require_once 'init.php';

$auth = new Auth();
$auth->logout();

setFlash("Je bent succesvol uitgelogd.", "info");
redirect('login.php');
exit;

?>

