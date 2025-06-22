<?php
require_once __DIR__ . '/init.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    setFlash("Je bent al ingelogd.", "info");
    redirect('dashboard.php');
} else {
    //redirect('login.php');
    header("Location: login.php");
    exit;
}
?>