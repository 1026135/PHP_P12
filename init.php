<?php

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/classes/' . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/config.php';
?>