<?php
require_once 'init.php';
require_once 'helpers/functions.php';

$auth = new Auth();
$auth->logout();

//header('Location: login.php');
redirect('login.php');
exit;
