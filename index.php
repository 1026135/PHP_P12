<?php
require_once 'init.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
exit;
?>