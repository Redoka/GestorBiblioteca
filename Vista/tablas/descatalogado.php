<?php
require_once __DIR__ . "/../../Controlador/descatalogado-controller.php";
require_once __DIR__ . "/../../Modelo/usuario.php";

session_start();

$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

$descatalogados = getDescatalogados();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Libros descatalogados</title>
    <link rel="stylesheet" href="/estilo.css">
</head>

<body>

<div class="layout">

    <aside class="sidebar">
        <h1>Menú</h1>

        <a href="/Vista/tablas/tabla-historial.php">Historial</a>
        <a href="/Vista/tablas/tabla-libro.php">Libros</a>
        <a href="/Vista/tablas/tabla-descatalogado.php">Descatalogados</a>
        <a href="/Vista/fichas/ficha-usuario.php">Mi usuario</a>

        <?php if ($admin): ?>
            <a href="/Vista/tablas/tabla-usuario.php">Usuarios</a>
        <?php endif; ?>
    </aside>

    <main class="content">

        <div class="card">

            <h1>Libros descatalogados</h1>

            <table>

                <thead>
                    <tr>
                        <th> </th>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha publicación</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($descatalogados)): ?>

                        <?php foreach ($descatalogados as $d): ?>

                            <tr>

                                <td>

                                    <div class="acciones">

                                        <form action="/intermedio/descatalogar.php" method="POST">

                                            <input type="hidden"
                                                   name="id"
                                                   value="<?= $d->idLibro->id ?>">

                                            <button type="submit"
                                                    class="delete-button">
                                                ×
                                            </button>

                                        </form>

                                    </div>

                                </td>

                                <td>
                                    <span class="badge">
                                        <?= $d->idLibro->id ?>
                                    </span>
                                </td>

                                <td>
                                    <?= $d->idLibro->isbn ?>
                                </td>

                                <td>
                                    <strong>
                                        <?= $d->idLibro->titulo ?>
                                    </strong>
                                </td>

                                <td>
                                    <?= $d->idLibro->autor ?>
                                </td>

                                <td>
                                    <?= $d->idLibro->fechaDePublicacion instanceof DateTime
                                        ? $d->idLibro->fechaDePublicacion->format('d-m-Y')
                                        : $d->idLibro->fechaDePublicacion ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="empty">
                                No hay libros descatalogados
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>

</html>