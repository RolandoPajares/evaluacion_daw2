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
            <label for="id_facultad">Facultad</label>
            <select id="id_facultad" name="id_facultad" required>
                <option value="">Seleccione una facultad</option>
                <?php foreach ($facultades as $facultad): ?>
                    <option value="<?= e($facultad['id']) ?>" <?= ((int)($docente['id_facultad'] ?? 0) === (int)$facultad['id']) ? 'selected' : '' ?>>
                        <?= e($facultad['nombre'] . ' (' . $facultad['abreviatura'] . ')') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="dni">DNI</label>
            <input id="dni" name="dni" maxlength="8" pattern="[0-9]{8}" required value="<?= e($docente['dni'] ?? '') ?>">

            <label for="apellidos">Apellidos</label>
            <input id="apellidos" name="apellidos" maxlength="100" required value="<?= e($docente['apellidos'] ?? '') ?>">

            <label for="nombres">Nombres</label>
            <input id="nombres" name="nombres" maxlength="100" required value="<?= e($docente['nombres'] ?? '') ?>">

            <label for="correo">Correo</label>
            <input id="correo" type="email" name="correo" maxlength="150" required value="<?= e($docente['correo'] ?? '') ?>">

            <label for="categoria">Categoría</label>
            <select id="categoria" name="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= e($categoria) ?>" <?= (($docente['categoria'] ?? '') === $categoria) ? 'selected' : '' ?>><?= e($categoria) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="dedicacion">Dedicación</label>
            <select id="dedicacion" name="dedicacion" required>
                <option value="">Seleccione una dedicación</option>
                <?php foreach ($dedicaciones as $dedicacion): ?>
                    <option value="<?= e($dedicacion) ?>" <?= (($docente['dedicacion'] ?? '') === $dedicacion) ? 'selected' : '' ?>><?= e($dedicacion) ?></option>
                <?php endforeach; ?>
            </select>

            <div class="form-actions">
                <button class="button" type="submit">Guardar</button>
                <a href="<?= base_url('docentes') ?>">Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>