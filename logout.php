<?php
require 'config/config.php';
require 'classes/Auth.php';

$auth = new Auth();
$auth->logout();

header('Location: login.php');
exit;
