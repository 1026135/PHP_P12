<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
    redirect('login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setFlash("Geen geldig product geselecteerd.", "error");
    redirect('products/products.php');
}

$productData = new Product();
$product = $productData->getProductById((int) $_GET['id']);

if (!$product) {
    setFlash("Product niet gevonden.", "error");
    redirect('products/products.php');
}
?>

<?php 
$pageTitle = "Product Details";
include ROOT_PATH . '/templates/header.php';
?>

<h2><?= escapeHtml($pageTitle) ?></h2>

<p><a href="<?= url('products/products.php') ?>">← Terug naar producten</a></p>

<p><strong>Naam:</strong> <?= escapeHtml($product['name']) ?></p>
<p><strong>Beschrijving:</strong> <?= nl2br(escapeHtml($product['description'])) ?></p>
<p><strong>Prijs:</strong> €<?= number_format((float)$product['price'], 2, ',', '.') ?></p>
<p><strong>Aangemaakt op:</strong> <?= escapeHtml($product['created_at']) ?></p>

<?php include ROOT_PATH . '/templates/footer.php'; ?>
