<?php
require_once '../init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    redirect('login.php');
}

$currentUser = $auth->getUser();
$product = new Product();

if ($auth->isAdmin()) {
    $products = $product->getAllProducts();
} else {
    redirect('dashboard.php');
}
?>

<?php 
$pageTitle = "Products";
include 'templates/header.php';
?>

<h2>Products</h2>
<p>
    Welcome, <?= escapeHtml($currentUser['name']) ?> |
    <a href="<?= url('dashboard.php') ?>">Dashboard</a> |
    <a href="<?= url('logout.php') ?>">Logout</a>
</p>

<a href="<?= url('product_add.php') ?>">➕ Add Product</a>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Created At</th>
        <th style="text-align: center;">Actions</th>
    </tr>
    <?php if (!empty($products)):?> 
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= escapeHtml($product['name']) ?></td>
                <td><?= escapeHtml($product['description']) ?></td>
                <td>€<?= number_format($product['price'], 2) ?></td>
                <td><?= escapeHtml($product['created_at']) ?></td>

                <td style="text-align: center; white-space: nowrap;">
                    <a href="<?= url('product_view.php?id=' . $product['id']) ?>">View</a> |
                    <a href="<?= url('product_edit.php?id=' . $product['id']) ?>">Edit</a> |
                    <form action="product_delete.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <input type="hidden" name="id" value="<?= $product['id'] ?>">
                        <button type="submit" style="background:none; border:none; color:blue; cursor:pointer; padding:0; font:inherit;">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5">No products found.</td></tr>
    <?php endif; ?>
</table>

<?php include 'templates/footer.php'; ?>
