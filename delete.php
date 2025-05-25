<?php
require_once 'classes/Auth.php';
require_once 'classes/User.php';
require_once 'helpers/functions.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    //header('Location: login.php');
    redirect('login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $user = new User();
    $id = (int)$_POST['id'];
    $user->deleteUser($id);
}

//header('Location: dashboard.php');
redirect('dashboard.php');
exit;

