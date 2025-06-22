<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($pageTitle) ? escapeHtml($pageTitle) : 'My Website'; ?></title>
    <link rel="stylesheet" href="<?= url('#') ?>" />
</head>
<body>
    <?php if ($flash = getFlash()): ?>
        <div style="padding: 10px; margin: 10px 0; border: 1px solid <?= $flash['type'] === 'error' ? 'red' : 'green' ?>; color: <?= $flash['type'] === 'error' ? 'red' : 'green' ?>;">
            <?= escapeHtml($flash['message']) ?>
        </div>
    <?php endif; ?>
    <header>
        <nav>
            <ul>
                <?php if ($auth->isLoggedIn()): ?>
                    <li><a href="<?= url('dashboard.php') ?>">Dashboard</a></li>
                    <li><a href="<?= url('account.php') ?>">Mijn Account</a></li>
                    <li><a href="<?= url('products/products.php') ?>">Producten</a></li>
                    <li><a href="<?= url('logout.php') ?>">Uitloggen</a></li>
                <?php else: ?>
                    <li><a href="<?= url('login.php') ?>">Inloggen</a></li>
                    <li><a href="<?= url('register.php') ?>">Registreren</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>

