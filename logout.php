<?php
require_once 'init.php';


$auth = new Auth();
$auth->logout();

redirect('login.php');
exit;
