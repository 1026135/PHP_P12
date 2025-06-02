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
        'type' => $type // bv. success, error, warning
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

?>


        <?php if ($flash = getFlash()): ?>
            <div style="padding: 10px; margin: 10px 0; border: 1px solid <?= $flash['type'] === 'error' ? 'red' : 'green' ?>; color: <?= $flash['type'] === 'error' ? 'red' : 'green' ?>;">
                <?= escapeHtml($flash['message']) ?>
            </div>
        <?php endif; ?>  