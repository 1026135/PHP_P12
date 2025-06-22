<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze pagina te bekijken.", "error");
    redirect('login.php');
}

$currentUser = $auth->getUser();
$productData = new Product();

if ($auth->isAdmin()) {
    $products = $productData->getAllProducts();
} else {
    $products = $productData->getProductByUserId($currentUser['id']);
}
?>

<?php 
$pageTitle = "Producten";
include ROOT_PATH . 'templates/header.php';
?>

<h2><?= escapeHtml($pageTitle) ?></h2>
<p>
    Welkom, <?= escapeHtml($currentUser['name']) ?> |
    <a href="<?= url('dashboard.php') ?>">Dashboard</a> |
    <a href="<?= url('logout.php') ?>">Uitloggen</a>
</p>

<a href="<?= url('products/product_add.php') ?>">➕ Product toevoegen</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Naam</th>
        <th>Beschrijving</th>
        <th>Prijs</th>
        <th>Aangemaakt op</th>
        <th style="text-align: center;">Acties</th>
    </tr>
    <?php if (!empty($products)): ?> 
        <?php foreach ($products as $item): ?>
            <tr>
                <td><?= escapeHtml($item['name']) ?></td>
                <td><?= escapeHtml($item['description']) ?></td>
                <td>€<?= number_format((float)$item['price'], 2, ',', '.') ?></td>
                <td><?= date('d-m-Y H:i', strtotime($item['created_at'])) ?></td>
                <td style="text-align: center; white-space: nowrap;">
                    <a href="<?= url('products/product_view.php?id=' . (int)$item['id']) ?>">Bekijken</a> |
                    <a href="<?= url('products/product_edit.php?id=' . $item['id']) ?>">Bewerken</a> |
                    <form action="<?= url('products/product_delete.php') ?>" method="post" style="display:inline;" onsubmit="return confirm('Weet je het zeker?');">
                        <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
                        <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; padding:0; font:inherit;">Verwijderen</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">Geen producten gevonden.</td></tr>
    <?php endif; ?>
</table>

<?php include ROOT_PATH . 'templates/footer.php'; ?>
