<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!-- Dynamic page title -->
    <title><?= APP_NAME ?></title>

    <!-- Responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS (CDN) -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Custom styles -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/styles.css">

</head>

<!-- Main page layout -->
<body class="d-flex flex-column min-vh-100 bg-light">

<?php require_once __DIR__ . '/navbar.php'; ?>

<!-- Main content container -->
<div class="container my-4">

    <!-- Flash message feedback -->
    <?php if ($flash = getFlash()): ?>
        <div class="alert alert-<?= $flash['type'] ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>





