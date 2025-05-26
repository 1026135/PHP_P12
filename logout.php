<?php
require_once 'init.php';
require_once 'helpers/functions.php';

$auth = new Auth();
$auth->logout();

redirect('login.php');
exit;
