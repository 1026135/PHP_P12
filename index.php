<?php
require_once 'init.php';
require_once 'helpers/functions.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    //header('Location: dashboard.php');
    redirect('dashboard.php');
} else {
    //header('Location: login.php');
    redirect('login.php');
}
exit;
?>