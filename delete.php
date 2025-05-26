<?php
require_once 'init.php';
require_once 'helpers/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user = new User();
    $id = (int)$_POST['id'];
    $user->deleteUser($id);
}

redirect('dashboard.php');
exit;

