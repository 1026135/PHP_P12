<?php
require_once 'config/config.php';
require_once 'classes/Auth.php';
require_once 'helpers/functions.php';

$auth = new Auth();
$auth->logout();

//header('Location: login.php');
redirect('login.php');
exit;
