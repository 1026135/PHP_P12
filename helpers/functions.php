<?php

// URL Helpers //
function redirect($url, $sendHeader = true) {
    // If $url is not an absolute URL or root-relative, prepend BASE_URL
    if ($url === '' || (strpos($url, 'http') !== 0 && $url[0] !== '/')) {
        $url = BASE_URL . $url;
    }

    if ($sendHeader) {
        header("Location: $url");
        exit;
    }

    // Return the safe URL for use in HTML
    return escapeHtml($url);
}

function url($url) {
    return redirect($url, false);
}
// URL Helpers //


// Security Helpers //
function escapeHtml($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
// Security Helpers //


// Notification & Debug Tools //
function setFlash(string $message, string $type = 'success'): void {
    $_SESSION['flash'] = [
        'message' => $message,
        'type' => $type
    ];
}

function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}


// For troubleshooting
function checkSessionInfo() {
    echo '<pre>';
    print_r($_SESSION['user']);
    echo '</pre>';
}
// Notification & Debug Tools //
?>