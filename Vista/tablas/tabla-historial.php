<?php
require_once __DIR__ . "/../../Controlador/historial-controller.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$historial = array();
$admin = $usuario->tipoUsuario == 1;
if ($admin) {
    $historial = getHistorial();
} else {
    $historial = getHistorialByIdUsuario($usuario->id);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de préstamos</title>
    <link rel="stylesheet" href="/estilo.css">

</head>

<body>

    <div class="layout">

        <aside class="sidebar">
            <h1>Menú</h1>

            <a href="tabla-historial.php">Historial</a>
            <a href="tabla-libro.php">Libros</a>
            <a href="/Vista/fichas/ficha-usuario.php">Mi usuario</a>
            <?php if ($admin) {
                echo "<a href=\"/Vista/tablas/tabla-usuario.php\">Usuarios</a>";
            } ?>
        </aside>

        <main class="content">

            <div class="card">

                <h1>Préstamos</h1>

                <table>

                    <thead>
                        <tr>
                            <th> </th>
                            <th>ID Libro</th>
                            <th>Nombre Libro</th>
                            <th>ID Usuario</th>
                            <th>Nombre Usuario</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Entrega</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $h): ?>
                                <tr>
                                    <td>
                                        <div class="acciones">

                                            <?php if ($admin): ?>
                                                <a class="delete-button"
                                                    href="/intermedio/deleted-history.php?id=<?= (int)$h->id ?>">
                                                    ×
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($h->fechaEntrega === null): ?>
                                                <a class="return-button"
                                                    href="/intermedio/return.php?id=<?= (int)$h->id ?>">
                                                    ↩
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                    </td>

                                    <td>
                                        <a href="/Vista/fichas/ficha-libro.php?id=<?= urlencode($h->idLibro->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $h->idLibro->id ?></span>
                                        </a>
                                    </td>

                                    <td><?= htmlspecialchars($h->idLibro->titulo) ?></td>

                                    <td>
                                        <a href="/Vista/fichas/ficha-usuario.php?id=<?= urlencode($h->idUsuario->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $h->idUsuario->id ?></span>
                                        </a>
                                    </td>

                                    <td><?= $h->idUsuario->nombre ?></td>

                                    <td>
                                        <?= $h->fechaPrestamo instanceof DateTime
                                            ? $h->fechaPrestamo->format('Y-m-d')
                                            : $h->fechaPrestamo
                                        ?>
                                    </td>

                                    <td>
                                        <?= $h->fechaEntrega instanceof DateTime
                                            ? $h->fechaEntrega->format('Y-m-d')
                                            : $h->fechaEntrega
                                        ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty">No hay historial disponible</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>

        </main>

    </div>

</body>

</html>