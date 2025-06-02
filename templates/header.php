<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo isset($pageTitle) ? escapeHtml($pageTitle) : 'My Website'; ?></title>
    <link rel="stylesheet" href="#" />
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="logout.php">Uitloggen</a></li>
                <li><a href="register.php">Registreren</a></li>
                <li><a href="account.php">Mijn account</a></li>
            </ul>
        </nav>
    </header>
    <main>

