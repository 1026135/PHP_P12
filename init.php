<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/helpers/functions.php';
?>