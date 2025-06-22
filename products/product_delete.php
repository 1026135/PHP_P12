<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
}

if (!$auth->isAdmin()) {
    setFlash("Je moet een admin zijn om deze actie uit te voeren.", "error");
    redirect('products/products.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $product = new Product();
    $id = (int)$_POST['id'];

    // (optioneel) controleer of product bestaat
    if ($product->getProductById($id)) {
        $product->deleteProduct($id);
        setFlash("Product succesvol verwijderd.", "success");
    } else {
        setFlash("Product niet gevonden.", "error");
    }
} else {
    setFlash("Ongeldige aanvraag.", "error");
}

redirect('products/products.php');
?>
