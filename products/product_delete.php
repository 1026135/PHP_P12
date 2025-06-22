<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
}

$currentUser = $auth->getUser();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    setFlash("Ongeldige aanvraag.", "error");
    redirect('products/products.php');
}

$productData = new Product();
$id = (int)$_POST['id'];

$product = $productData->getProductById($id);

if (!$product) {
    setFlash("Product niet gevonden.", "error");
    redirect('products/products.php');
}

if ($product['user_id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('products/products.php');
}

if ($productData->deleteProduct($id)) {
    setFlash("Product succesvol verwijderd.", "success");
} else {
    setFlash("Fout bij verwijderen van product.", "error");
}

redirect('products/products.php');
?>