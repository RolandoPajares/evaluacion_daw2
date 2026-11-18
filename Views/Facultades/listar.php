<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facultades</title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>
<body>
<main class="container wide">
    <div class="topbar">
        <h1>Facultades activas</h1>
        <a class="button" href="<?= base_url('facultades/crear') ?>">+ Nueva facultad</a>
    </div>
    <p><a href="<?= base_url() ?>">Inicio</a> | <a href="<?= base_url('facultades') ?>">Facultades</a></p>
    <table>
        <thead><tr><th>Nombre</th><th>Abreviatura</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php if (!$facultades): ?>
            <tr><td colspan="3">No hay facultades activas.</td></tr>
        <?php endif; ?>
        <?php foreach ($facultades as $facultad): ?>
            <tr>
                <td><?= e($facultad['nombre']) ?></td>
                <td><?= e($facultad['abreviatura']) ?></td>
                <td class="actions">
                    <a href="<?= base_url('facultades/editar/' . $facultad['id']) ?>">Editar</a>
                    <form method="post" action="<?= base_url('facultades/eliminar/' . $facultad['id']) ?>" onsubmit="return confirm('¿Desactivar esta facultad?');">
                        <button class="link-button" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>

