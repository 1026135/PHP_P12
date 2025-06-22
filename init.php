<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', __DIR__ . '/'); //root path to C:\xampp\htdocs\Github code\PHP_P12\

require_once ROOT_PATH . 'config/config.php';
require_once ROOT_PATH . 'helpers/functions.php';

spl_autoload_register(function ($class) {
    $path = ROOT_PATH . 'classes/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});
