<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Proyecto MVC') ?></title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>
<body>
    <main class="container">
        <h1><?= e($title ?? 'Proyecto MVC') ?></h1>
        <p><?= e($message ?? '') ?></p>
        <nav class="menu">
            <a class="button" href="<?= base_url('facultades') ?>">Gestionar facultades</a>
            <a class="button" href="<?= base_url('docentes') ?>">Gestionar docentes</a>
        </nav>
    </main>
</body>
</html>

