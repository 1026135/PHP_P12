<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om dit te bekijken.", "error");
    redirect('login.php');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setFlash("Geen product gespecificeerd.", "error");
    redirect('products/products.php');
}

$currentUser = $auth->getUser();
$productData = new Product();
$product = $productData->getProductById($currentUser['id']);

if (!$product) {
    setFlash("Product niet gevonden.", "error");
    redirect('products/products.php');
}

if ($product['user_id'] !== $currentUser['id'] && !$auth->isAdmin()) {
    setFlash("Je hebt geen rechten om deze actie uit te voeren.", "error");
    redirect('products/products.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if ($name === '') {
        setFlash("Naam is verplicht.", "error");
    } elseif ($description === '') {
        setFlash("Beschrijving is verplicht.", "error");
    } elseif ($price === '' || !is_numeric(str_replace(',', '.', $price)) || $price < 0) {
        setFlash("Voer een geldige prijs in.", "error");
    } else {
        $price = (float) str_replace(',', '.', $price);
        if ($productData->updateProduct($id, ['name' => $name, 'description' => $description, 'price' => $price])) {
            setFlash("Product succesvol bijgewerkt.", "success");
            redirect('products/products.php');
        } else {
            setFlash("Fout bij het bijwerken van het product.", "error");
        }
    }
}

$pageTitle = "Product Bewerken";
include ROOT_PATH . '/templates/header.php';
?>

<h2><?= escapeHtml($pageTitle) ?></h2>

<form action="<?= url('products/product_edit.php?id=' . $product['id']) ?>" method="post">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">

    <p>
        <label>Naam:<br>
            <input type="text" name="name" value="<?= escapeHtml($_POST['name'] ?? $product['name']) ?>" required>
        </label>
    </p>

    <p>
        <label>Beschrijving:<br>
            <textarea name="description" rows="5" required><?= escapeHtml($_POST['description'] ?? $product['description']) ?></textarea>
        </label>
    </p>

    <p>
        <label>Prijs (€):<br>
            <input type="number" step="0.01" name="price" value="<?= escapeHtml($_POST['price'] ?? $product['price']) ?>" required>
        </label>
    </p>

    <p>
        <button type="submit">Opslaan</button>
        <a href="<?= url('products/products.php') ?>">Annuleren</a>
    </p>

</form>

<?php include ROOT_PATH . '/templates/footer.php'; ?>
