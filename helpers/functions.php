<?php
function redirect($url) {
    header("Location: $url");
    exit;
}

function escapeHtml($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>