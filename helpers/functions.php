<?php
function redirect($url) {
    header("Location: $url");
    exit;
}

function escapeHtml($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}



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
?>