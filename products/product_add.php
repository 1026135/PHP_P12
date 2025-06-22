<?php
require_once __DIR__ . '/../init.php';

$auth = new Auth();
if (!$auth->isLoggedIn()) {
    setFlash("Je moet ingelogd zijn om deze actie uit te voeren.", "error");
    redirect('login.php');
}

$product = new Product();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        if ($product->addProduct([
            'name' => $name,
            'description' => $description,
            'price' => $price
        ])) {
            setFlash("Product succesvol toegevoegd.", "success");
            redirect('products/products.php');
        } else {
            setFlash("Fout bij toevoegen van product.", "error");
        }
    }
}

$pageTitle = "Product Toevoegen";
include ROOT_PATH . '/templates/header.php';
?>

<h2><?= escapeHtml($pageTitle) ?></h2>

<form action="<?= url('products/product_add.php') ?>" method="post">
    <label for="name">Naam:</label><br>
    <input type="text" id="name" name="name" value="<?= escapeHtml($_POST['name'] ?? '') ?>" required><br><br>

    <label for="description">Beschrijving:</label><br>
    <textarea id="description" name="description" rows="5" required><?= escapeHtml($_POST['description'] ?? '') ?></textarea><br><br>

    <label for="price">Prijs (€):</label><br>
    <input type="number" step="0.01" id="price" name="price" value="<?= escapeHtml($_POST['price'] ?? '') ?>" required><br><br>

    <button type="submit">Toevoegen</button>
</form>

<?php include BASE_PATH . '/templates/footer.php'; ?>
