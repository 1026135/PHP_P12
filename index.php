<?php
require_once 'init.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    setFlash("Je bent al ingelogd.", "info");
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
exit;
?>