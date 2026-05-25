<?php
require_once __DIR__ . "/../../controlador/historial-controller.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$historial = array();
$admin = $usuario->tipoUsuario == 1;

$pagina = $_GET['pagina'] ?? 1;
$pagina = max(1, (int)$pagina);

$porPagina = 10;

$offset = ($pagina - 1) * $porPagina;
$totalLibros = 0;
$totalPaginas = 0;

if ($admin) {
    $totalLibros = countHistorial();
    $totalPaginas = ceil($totalLibros / $porPagina);
    $historial = getHistorial($porPagina, $offset);
} else {
    $totalLibros = countHistorialUsuario($usuario->id);
    $totalPaginas = ceil($totalLibros / $porPagina);
    $historial = getHistorialByIdUsuario($usuario->id, $porPagina, $offset);
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

            <a href="historial.php">Historial</a>
            <a href="libros.php">Libros</a>
            <?php
            if ($admin) {
                echo "<a href='/vista/tablas/descatalogado.php'>Descatalogados</a>";
                echo "<a href='/vista/tablas/usuarios.php'>Usuarios</a>";
            }
            ?>
            <a href="/vista/fichas/usuario.php">Mi usuario</a>
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
                                                    href="/intermedio/borrar-historial.php?id=<?= (int)$h->id ?>">
                                                    ×
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($h->fechaEntrega === null): ?>
                                                <a class="return-button"
                                                    href="/intermedio/devolver.php?id=<?= (int)$h->id ?>">
                                                    ↩
                                                </a>
                                            <?php endif; ?>

                                        </div>
                                    </td>

                                    <td>
                                        <a href="/vista/fichas/libro.php?id=<?= urlencode($h->idLibro->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $h->idLibro->id ?></span>
                                        </a>
                                    </td>

                                    <td><?= htmlspecialchars($h->idLibro->titulo) ?></td>

                                    <td>
                                        <a href="/vista/fichas/usuario.php?id=<?= urlencode($h->idUsuario->id) ?>" style="text-decoration:none;">
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

                <div class="pagination">

                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?= $pagina - 1 ?>">←</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>

                        <a href="?pagina=<?= $i ?>"
                            class="<?= $i == $pagina ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>

                    <?php endfor; ?>

                    <?php if ($pagina < $totalPaginas): ?>
                        <a href="?pagina=<?= $pagina + 1 ?>">→</a>
                    <?php endif; ?>

                </div>

            </div>

        </main>

    </div>

</body>

</html>