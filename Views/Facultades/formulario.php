<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>

<body>
    <main class="container form-container">
        <h1><?= e($title) ?></h1>
        <?php if (!empty($error)): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
        <form method="post" action="<?= base_url($action) ?>">
            <label for="nombre">Nombre</label>

            <input id="nombre" name="nombre" maxlength="120" required value="<?= e($facultad['nombre'] ?? '') ?>">

            <label for="abreviatura">Abreviatura</label>

            <input id="abreviatura" name="abreviatura" maxlength="20" required value="<?= e($facultad['abreviatura'] ?? '') ?>">

            <div class="form-actions">
                <button class="button" type="submit">Guardar</button>
                <a href="<?= base_url('facultades') ?>">Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>