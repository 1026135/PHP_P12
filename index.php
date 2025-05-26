<?php
require_once 'init.php';
require_once 'helpers/functions.php';

$auth = new Auth();

if ($auth->isLoggedIn()) {
    redirect('dashboard.php');
} else {
    redirect('login.php');
}
exit;
?>