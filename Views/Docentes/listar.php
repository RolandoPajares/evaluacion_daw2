<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docentes</title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>

<body>
    <main class="container wide">
        <div class="topbar">
            <h1>Docentes activos</h1>
            <a class="button" href="<?= base_url('docentes/crear') ?>">+ Nuevo docente</a>
        </div>
        <p><a href="<?= base_url() ?>">Inicio</a> | <a href="<?= base_url('docentes') ?>">Docentes</a></p>
        <table>
            <thead>
                <tr>
                    <th>Facultad</th>
                    <th>DNI</th>
                    <th>Apellidos y nombres</th>
                    <th>Correo</th>
                    <th>Categoría</th>
                    <th>Dedicación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$docentes): ?>
                    <tr>
                        <td colspan="7">No hay docentes activos.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($docentes as $docente): ?>
                    <tr>
                        <td><?= e($docente['facultad']) ?></td>
                        <td><?= e($docente['dni']) ?></td>
                        <td><?= e($docente['apellidos'] . ', ' . $docente['nombres']) ?></td>
                        <td><?= e($docente['correo']) ?></td>
                        <td><?= e($docente['categoria']) ?></td>
                        <td><?= e($docente['dedicacion']) ?></td>
                        <td class="actions">
                            <a href="<?= base_url('docentes/editar/' . $docente['id']) ?>">Editar</a>
                            <form method="post" action="<?= base_url('docentes/eliminar/' . $docente['id']) ?>" onsubmit="return confirm('¿Desactivar este docente?');">
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
